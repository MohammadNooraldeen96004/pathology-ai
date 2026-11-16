<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSlideRequest;
use App\Models\cases;
use App\Models\Slide;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;
use Illuminate\Support\Facades\Http;

class SlideController extends Controller
{
    /**
     * Store a pathology slide for the selected clinical case.
     */
    public function store(StoreSlideRequest $request, cases $case)
    {
        Gate::authorize('update', $case); //why update not 
        if ($case->status === 'completed') {
            return back()->with(
                'error',
                'Slides cannot be added to a completed case.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Get uploaded TIFF
        |--------------------------------------------------------------------------
        */

        $uploadedFile = $request->file('slide');

        $fileHash = hash_file(
            'sha256',
            $uploadedFile->getRealPath()
        );

        $alreadyExists = Slide::where(
            'file_hash',
            $fileHash
        )->exists();

        if ($alreadyExists) {
            return back()->with(
                'error',
                'This pathology slide is already registered in the system and cannot be uploaded again.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Read original file information
        |--------------------------------------------------------------------------
        */

        $originalName = $uploadedFile->getClientOriginalName();

        $extension = strtolower(
            $uploadedFile->getClientOriginalExtension()
        );


        /*
        |--------------------------------------------------------------------------
        | Generate safe unique storage name
        |--------------------------------------------------------------------------
        */

        $storedName = Str::uuid() . '.' . $extension;

        $directory = "cases/{$case->id}/slides";


        /*
        |--------------------------------------------------------------------------
        | Store file privately
        |--------------------------------------------------------------------------
        */

        $path = Storage::disk('local')->putFileAs(
            $directory,
            $uploadedFile,
            $storedName
        );


        if ($path === false) {
            return back()->with(
                'error',
                'The pathology slide could not be stored. Please try again.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Create database record
        |--------------------------------------------------------------------------
        |
        | If saving the database record fails after the physical file was stored,
        | remove the file again so we do not leave orphan files on disk.
        |
        */

        try {

            $slide = new Slide();

            $slide->file_name = $originalName;
            $slide->storage_path = $path;
            $slide->file_hash = $fileHash;

            $case->slides()->save($slide);
            if ($case->status === 'pending') {
                $case->update([
                    'status' => 'processing',
                ]);
            }
        } catch (Throwable $exception) { // ca

            Storage::disk('local')->delete($path);

            throw $exception;
        }


        return back()->with(
            'success',
            'Pathology slide uploaded successfully.'
        );
    }

    public function download(cases $case, Slide $slide)
    {
        Gate::authorize('view', $case); // ليش فيهه أكثر من مكان تحديد هل الدكتور هل له صلاحية ليش مش مرة وحده

        abort_if(
            $slide->case_id !== $case->id,
            404
        );

        abort_unless(
            $slide->storage_path &&
                Storage::disk('local')->exists($slide->storage_path),
            404
        );

        return response()->download(
            Storage::disk('local')->path($slide->storage_path),
            basename($slide->file_name)
        );
    }
    /**
     * Remove a pathology slide from a clinical case.
     */
    public function destroy(cases $case, Slide $slide)
    {
        Gate::authorize('update', $case);
        if ($case->status === 'completed') {
            return back()->with(
                'error',
                'Slides cannot be deleted from a completed case.'
            );
        }

        abort_if(
            $slide->case_id !== $case->id,
            404
        );

        $path = $slide->storage_path;

        /*
    |--------------------------------------------------------------------------
    | Delete physical TIFF
    |--------------------------------------------------------------------------
    */

        if (
            $path &&
            Storage::disk('local')->exists($path)
        ) {
            $deleted = Storage::disk('local')->delete($path);

            if (! $deleted) {
                return back()->with(
                    'error',
                    'The pathology slide file could not be deleted.'
                );
            }
        }

        /*
    |--------------------------------------------------------------------------
    | Delete database record
    |--------------------------------------------------------------------------
    */

        $slide->delete();

        return back()->with(
            'success',
            'Pathology slide deleted successfully.'
        );
    }
    public function viewerInfo(cases $case, Slide $slide)
    {
        Gate::authorize('view', $case);

        abort_if(
            $slide->case_id !== $case->id,
            404
        );

        $serviceUrl = rtrim(
            config('services.pathology.url'),
            '/'
        );

        $response = Http::timeout(30)->get(
            "{$serviceUrl}/slides/info",
            [
                'path' => $slide->storage_path,
            ]
        );

        if (! $response->successful()) {
            return response()->json(
                [
                    'message' => 'The pathology slide could not be opened.',
                ],
                502
            );
        }

        return response()->json(
            $response->json()
        );
    }

    public function tile(
        cases $case,
        Slide $slide,
        int $level,
        int $column,
        int $row
    ) {
        Gate::authorize('view', $case);

        abort_if(
            $slide->case_id !== $case->id,
            404
        );

        $serviceUrl = rtrim(
            config('services.pathology.url'),
            '/'
        );

        $response = Http::timeout(30)->get(
            "{$serviceUrl}/slides/tiles/{$level}/{$column}/{$row}",
            [
                'path' => $slide->storage_path,
            ]
        );

        if (! $response->successful()) {
            abort($response->status() === 404 ? 404 : 502);
        }

        return response(
            $response->body(),
            200,
            [
                'Content-Type' => 'image/png',
                'Cache-Control' => 'private, max-age=3600',
            ]
        );
    }
}
