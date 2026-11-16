<?php

namespace App\Http\Controllers;

use App\Models\AiAnalysis;
use App\Models\cases;
use App\Models\Slide;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class AiAnalysisController extends Controller
{
    public function run(
        cases $case,
        Slide $slide
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | 1. Authorization
        |--------------------------------------------------------------------------
        |
        | Only the doctor who owns this case may run AI analysis.
        |
        */

        Gate::authorize('update', $case);


        /*
        |--------------------------------------------------------------------------
        | 2. Nested resource protection
        |--------------------------------------------------------------------------
        |
        | The supplied slide must actually belong to this case.
        |
        */

        abort_if(
            $slide->case_id !== $case->id,
            404
        );


        /*
        |--------------------------------------------------------------------------
        | 3. Completed cases should not be changed
        |--------------------------------------------------------------------------
        */

        if ($case->status === 'completed') {
            return back()->with(
                'error',
                'A completed case cannot be analyzed again.'
            );
        }



        /*
        |--------------------------------------------------------------------------
        | 5. Check current analysis state
        |--------------------------------------------------------------------------
        */

        $slide->loadMissing('aiAnalysis');

        if ($slide->aiAnalysis?->status === 'processing') {
            return back()->with(
                'error',
                'AI analysis is already in progress.'
            );
        }

        if ($slide->aiAnalysis?->status === 'completed') {
            return back()->with(
                'error',
                'AI analysis has already been completed for this slide.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | 6. Create/update the one AI analysis record for this slide
        |--------------------------------------------------------------------------
        */

        $analysis = AiAnalysis::updateOrCreate(
            [
                'slide_id' => $slide->id,
            ],
            [
                'score' => null,
                'prediction' => null,
                'model_version' => null,
                'status' => 'processing',
                'analyzed_at' => null,
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | 7. Case workflow has now entered processing
        |--------------------------------------------------------------------------
        */

        if ($case->status === 'pending') {
            $case->update([
                'status' => 'processing',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | 8. Ask the internal Python service to run the model
        |--------------------------------------------------------------------------
        */

        try {

            $response = Http::timeout(300)
                ->post(
                    config('services.pathology.url') . '/analysis/run',
                    [
                        'storage_path' => $slide->storage_path,
                    ]
                );


            /*
            |--------------------------------------------------------------------------
            | 9. FastAPI returned an error
            |--------------------------------------------------------------------------
            */

            if (!$response->successful()) {

                $analysis->update([
                    'status' => 'pending',
                    'score' => null,
                    'prediction' => null,
                    'model_version' => null,
                    'analyzed_at' => null,
                ]);

                Log::warning(
                    'AI analysis request failed.',
                    [
                        'slide_id' => $slide->id,
                        'status_code' => $response->status(),
                        'response' => $response->body(),
                    ]
                );

                return back()->with(
                    'error',
                    $response->json('detail')
                        ?? 'AI analysis failed.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | 10. Read the AI result
            |--------------------------------------------------------------------------
            */

            $prediction = $response->json(
                'prediction'
            );

            $score = $response->json(
                'score'
            );

            $modelVersion = $response->json(
                'model_version'
            );


            /*
            |--------------------------------------------------------------------------
            | 11. Validate the response before saving it
            |--------------------------------------------------------------------------
            */

            if (
                !is_string($prediction) ||
                !is_numeric($score) ||
                !is_string($modelVersion)
            ) {

                $analysis->update([
                    'status' => 'pending',
                ]);

                Log::error(
                    'AI service returned an invalid response.',
                    [
                        'slide_id' => $slide->id,
                        'response' => $response->json(),
                    ]
                );

                return back()->with(
                    'error',
                    'The AI service returned an invalid result.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | 12. Save successful result
            |--------------------------------------------------------------------------
            */

            $analysis->update([
                'score' => $score,
                'prediction' => $prediction,
                'model_version' => $modelVersion,
                'status' => 'completed',
                'analyzed_at' => now(),
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
                    'AI analysis completed successfully.'
                );
        } catch (Throwable $exception) {

            /*
            |--------------------------------------------------------------------------
            | 13. FastAPI unavailable / timeout / unexpected error
            |--------------------------------------------------------------------------
            */

            $analysis->update([
                'status' => 'pending',
                'score' => null,
                'prediction' => null,
                'model_version' => null,
                'analyzed_at' => null,
            ]);

            Log::error(
                'AI analysis service error.',
                [
                    'slide_id' => $slide->id,
                    'message' => $exception->getMessage(),
                ]
            );

            return back()->with(
                'error',
                'The AI analysis service is currently unavailable.'
            );
        }
    }
}
