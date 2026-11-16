<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveDoctorReviewRequest;
use App\Models\cases;
use App\Models\DoctorReview;
use App\Models\Slide;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DoctorReviewController extends Controller
{
    public function save(
        SaveDoctorReviewRequest $request,
        cases $case,
        Slide $slide
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        Gate::authorize('update', $case);

        if ($case->status === 'completed') {
            return back()->with(
                'error',
                'A completed case cannot be reviewed again.'
            );
        }
        /*
        |--------------------------------------------------------------------------
        | Make sure this slide belongs to this case
        |--------------------------------------------------------------------------
        */

        abort_if(
            $slide->case_id !== $case->id,
            404
        );


        /*
        |--------------------------------------------------------------------------
        | AI must be completed before clinical review
        |--------------------------------------------------------------------------
        */

        $slide->loadMissing('aiAnalysis');

        if (
            !$slide->aiAnalysis ||
            $slide->aiAnalysis->status !== 'completed'
        ) {
            return back()->with(
                'error',
                'AI analysis must be completed before this slide can be reviewed.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Create or update the ONE review belonging to this slide
        |--------------------------------------------------------------------------
        */
        if (
            DoctorReview::where('slide_id', $slide->id)->exists()
        ) {
            return back()->with(
                'error',
                'This slide has already been reviewed.'
            );
        }

        DoctorReview::create([
            'slide_id' => $slide->id,
            'doctor_id' => Auth::id(),
            'decision' => $request->validated('decision'),
            'notes' => $request->validated('notes'),
            'reviewed_at' => now(),
        ]);


        return redirect()
            ->route(
                'cases.show',
                [
                    'case' => $case,
                    'slide' => $slide->id,
                ]
            )
            ->with(
                'success',
                'Slide review saved successfully.'
            );
    }
}
