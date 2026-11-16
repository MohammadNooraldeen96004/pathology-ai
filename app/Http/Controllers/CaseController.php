<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCaseRequest;
use App\Models\cases;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpdateCaseRequest;
use Illuminate\Http\Request;

class CaseController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $status = $request->query('status');

        $cases = cases::with('patient')
            ->withCount('slides')
            ->where('doctor_id', Auth::id())

            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {

                    $subQuery
                        ->where('case_number', 'like', "%{$search}%")

                        ->orWhereHas('patient', function ($patientQuery) use ($search) {
                            $patientQuery
                                ->where('name', 'like', "%{$search}%")
                                ->orWhere('patient_code', 'like', "%{$search}%");
                        });
                });
            })

            ->when(
                in_array($status, ['pending', 'processing', 'completed'], true),
                function ($query) use ($status) {
                    $query->where('status', $status);
                }
            )

            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('cases.index', compact('cases', 'search', 'status'));
    }

    public function create()
    {
        $patients = Patient::orderBy('patient_code')->get();

        return view('cases.create', compact('patients'));
    }

    public function store(StoreCaseRequest $request)
    {
        $validated = $request->validated();

        $case = DB::transaction(function () use ($validated) {

            /*
        |--------------------------------------------------------------------------
        | Generate Patient Code
        |--------------------------------------------------------------------------
        */

            $lastPatient = Patient::withTrashed() // what the mean withTrashed()?
                ->where(
                    'patient_code',
                    'like',
                    'PAT-' . now()->format('Y') . '-%'
                )
                ->orderByDesc('patient_code')
                ->first();

            $nextPatientNumber = $lastPatient
                ? ((int) substr($lastPatient->patient_code, -5)) + 1
                : 1;

            $patientCode = 'PAT-' .
                now()->format('Y') .
                '-' .
                str_pad(
                    (string) $nextPatientNumber,
                    5,
                    '0',
                    STR_PAD_LEFT
                );


            /*
        |--------------------------------------------------------------------------
        | Create Patient
        |--------------------------------------------------------------------------
        */

            $patient = Patient::create([
                'name' => $validated['patient_name'],
                'patient_code' => $patientCode,
                'age' => $validated['age'] ?? null,
                'gender' => $validated['gender'] ?? null,
            ]);


            /*
        |--------------------------------------------------------------------------
        | Generate Case Number
        |--------------------------------------------------------------------------
        */

            $caseNumber = $this->generateCaseNumber();


            /*
        |--------------------------------------------------------------------------
        | Create Case
        |--------------------------------------------------------------------------
        */

            return cases::create([
                'patient_id' => $patient->id,
                'doctor_id' => Auth::id(),
                'case_number' => $caseNumber,
                'specialization' => $validated['specialization'] ?? null,
                'additional_info' => $validated['clinical_information'] ?? null,
                'expected_slides' => $validated['expected_slides'],
                'status' => 'pending',
                'icd10' => $validated['icd10'] ?? null,
            ]);
        });

        return redirect()
            ->route('cases.show', $case)
            ->with(
                'success',
                'Clinical case created successfully.'
            );
    }
    public function show(cases $case)
    {
        Gate::authorize('view', $case);

        $case->load(['patient', 'slides.AiAnalysis', 'slides.reports', 'slides.doctorReviews']);

        return view('cases.show', compact('case'));
    }

    public function edit(cases $case)
    {
        Gate::authorize('update', $case);

        if ($case->status === 'completed') {
            return redirect()
                ->route('cases.show', $case)
                ->with(
                    'error',
                    'A completed case is read-only.'
                );
        }

        $case->load('patient');

        abort_if(
            !$case->patient,
            409,
            'The patient record associated with this case is missing.'
        );

        return view('cases.edit', compact('case'));
    }

    public function update(UpdateCaseRequest $request, cases $case) // what is the difference between UpdateCaseRequest and StoreCaseRequest and editCaseRequest?
    {
        Gate::authorize('update', $case);
        if ($case->status === 'completed') {
            return redirect()
                ->route('cases.show', $case)
                ->with(
                    'error',
                    'A completed case cannot be modified.'
                );
        }

        $validated = $request->validated();

        DB::transaction(function () use ($case, $validated) {

            $case->loadMissing('patient');

            abort_if(
                !$case->patient,
                409,
                'The patient record associated with this case is missing.'
            );

            $case->patient->update([
                'name' => $validated['patient_name'],
                'age' => $validated['age'] ?? null,
                'gender' => $validated['gender'] ?? null,
            ]);

            $case->update([
                'specialization' => $validated['specialization'] ?? null,
                'additional_info' => $validated['clinical_information'] ?? null,
                'grossing' => $validated['grossing'] ?? null,
                'micro_protocol' => $validated['micro_protocol'] ?? null,
                'diff_diagnostic' => $validated['diff_diagnostic'] ?? null,
                'diagnosis' => $validated['diagnosis'] ?? null,
                'conclusion' => $validated['conclusion'] ?? null,
                'expected_slides' => $validated['expected_slides'],
            ]);
        });

        $navigation = array_filter([
            'search' => $request->query('search'),
            'status' => $request->query('status'),
            'page' => $request->query('page'),
        ], fn($value) => $value !== null && $value !== '');

        return redirect()
            ->route('cases.show', [
                'case' => $case,
                ...$navigation,
            ])
            ->with('success', 'Clinical case updated successfully.');
    }

    public function complete(cases $case)
    {
        Gate::authorize('update', $case);

        if ($case->status === 'completed') {
            return back()->with(
                'error',
                'This clinical case has already been completed.'
            );
        }

        $case->load([
            'slides.aiAnalysis',
            'slides.doctorReviews',
        ]);

        $uploadedSlides = $case->slides->count();

        $issues = [];


        /*
    |--------------------------------------------------------------------------
    | Required number of slides
    |--------------------------------------------------------------------------
    */

        if ($uploadedSlides < $case->expected_slides) {
            $issues[] =
                "Expected {$case->expected_slides} slide(s), but only {$uploadedSlides} uploaded.";
        }


        /*
    |--------------------------------------------------------------------------
    | Every uploaded slide must have completed AI analysis
    |--------------------------------------------------------------------------
    */

        $unanalyzedSlides = $case->slides->filter(
            fn($slide) =>
            !$slide->aiAnalysis ||
                $slide->aiAnalysis->status !== 'completed'
        )->count();

        if ($unanalyzedSlides > 0) {
            $issues[] =
                "{$unanalyzedSlides} slide(s) still require completed AI analysis.";
        }


        /*
    |--------------------------------------------------------------------------
    | Every uploaded slide must have a doctor review
    |--------------------------------------------------------------------------
    */

        $unreviewedSlides = $case->slides->filter(
            fn($slide) => !$slide->doctorReviews
        )->count();

        if ($unreviewedSlides > 0) {
            $issues[] =
                "{$unreviewedSlides} slide(s) still require doctor review.";
        }


        /*
    |--------------------------------------------------------------------------
    | Final case diagnosis
    |--------------------------------------------------------------------------
    */

        if (blank($case->diagnosis)) {
            $issues[] = 'Final diagnosis is required.';
        }


        /*
    |--------------------------------------------------------------------------
    | Final case conclusion
    |--------------------------------------------------------------------------
    */

        if (blank($case->conclusion)) {
            $issues[] = 'Final conclusion is required.';
        }


        /*
    |--------------------------------------------------------------------------
    | Do not complete an unfinished case
    |--------------------------------------------------------------------------
    */

        if (!empty($issues)) {
            return back()->with(
                'error',
                implode(' ', $issues)
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Complete case
    |--------------------------------------------------------------------------
    */

        $case->update([
            'status' => 'completed',
        ]);

        return redirect()
            ->route('cases.show', $case)
            ->with(
                'success',
                'Clinical case completed successfully.'
            );
    }
    public function destroy(cases $case)
    {
        Gate::authorize('delete', $case);

        $case->load('patient');

        DB::transaction(function () use ($case) {

            if ($case->patient) {
                $case->patient->delete();
            }

            $case->delete();
        });

        return redirect()
            ->back()
            ->with('success', 'Case deleted successfully.');
    }
    public function restore(int $id)
    {
        $case = cases::onlyTrashed()->findOrFail($id);

        Gate::authorize('restore', $case);

        DB::transaction(function () use ($case) {

            $patient = Patient::withTrashed()
                ->findOrFail($case->patient_id);

            if ($patient->trashed()) {
                $patient->restore();
            }

            $case->restore();
        });

        return redirect()
            ->route('cases.archive')
            ->with('success', 'Clinical case restored successfully.');
    }
    public function archive()
    {
        $cases = cases::onlyTrashed()
            ->with([
                'patient' => function ($query) {
                    $query->withTrashed();
                }
            ])
            ->where('doctor_id', Auth::id())
            ->latest('deleted_at')
            ->paginate(15);

        return view('cases.archive', compact('cases'));
    }
    private function generateCaseNumber(): string
    {
        $year = now()->year;

        $prefix = "CASE-{$year}-";

        $lastCase = cases::withTrashed()
            ->where('case_number', 'like', $prefix . '%')
            ->whereRaw(
                'case_number REGEXP ?',
                ["^CASE-{$year}-[0-9]+$"]
            )
            ->orderByRaw(
                "CAST(SUBSTRING_INDEX(case_number, '-', -1) AS UNSIGNED) DESC"
            )
            ->first();

        $lastNumber = 0;

        if (
            $lastCase &&
            preg_match(
                "/^CASE-{$year}-(\d+)$/",
                $lastCase->case_number,
                $matches
            )
        ) {
            $lastNumber = (int) $matches[1];
        }

        $nextNumber = $lastNumber + 1;

        return $prefix . str_pad(
            $nextNumber,
            4,
            '0',
            STR_PAD_LEFT
        );
    }
}
