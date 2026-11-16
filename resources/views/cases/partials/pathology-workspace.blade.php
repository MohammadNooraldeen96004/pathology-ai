   {{-- =========================================================
    DIGITAL PATHOLOGY WORKSPACE
========================================================== --}}

   @if ($case->slides->isNotEmpty())

       <section class="mt-6" x-data="pathologyViewer({
           slides: @js(
    $case->slides
        ->map(function ($slide) use ($case) {
            return [
                'id' => $slide->id,

                'name' => $slide->file_name,

                'infoUrl' => route('cases.slides.viewer-info', [$case, $slide]),

                'tileUrl' => route('cases.slides.tile', [$case, $slide, '__LEVEL__', '__COLUMN__', '__ROW__']),

                'runAnalysisUrl' => route('cases.slides.analysis.run', [$case, $slide]),

                'reviewUrl' => route('cases.slides.review.save', [$case, $slide]),

                'analysis' => $slide->aiAnalysis
                    ? [
                        'id' => $slide->aiAnalysis->id,
                        'status' => $slide->aiAnalysis->status,
                        'prediction' => $slide->aiAnalysis->prediction,
                        'score' => $slide->aiAnalysis->score,
                        'modelVersion' => $slide->aiAnalysis->model_version,
                        'analyzedAt' => $slide->aiAnalysis->analyzed_at?->toISOString(),
                    ]
                    : null,

                'review' => $slide->doctorReviews
                    ? [
                        'id' => $slide->doctorReviews->id,
                        'decision' => $slide->doctorReviews->decision,
                        'notes' => $slide->doctorReviews->notes,
                        'reviewedAt' => $slide->doctorReviews->reviewed_at?->toISOString(),
                    ]
                    : null,
            ];
        })
        ->values(),
),
           initialSlideId: {{ request('slide') ? (int) request('slide') : 'null' }}
       })" x-init="$nextTick(() => init())">

           {{-- =====================================================
            WORKSPACE TOP BAR
        ====================================================== --}}

           <div
               class="mb-3 flex flex-col gap-4
                   border-y border-white/[0.06]
                   bg-[#050B14]/70 px-5 py-4
                   lg:flex-row lg:items-center lg:justify-between">

               <div class="flex min-w-0 items-center gap-4">

                   <a href="{{ route('cases.index') }}"
                       class="flex h-9 w-9 shrink-0 items-center justify-center
                           rounded-lg border border-white/[0.08]
                           bg-white/[0.03] text-slate-400
                           transition hover:border-white/[0.15]
                           hover:text-white"
                       title="Back to cases">
                       <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                           <path d="M15 18l-6-6 6-6" />
                       </svg>
                   </a>


                   <div class="min-w-0">

                       <div class="flex flex-wrap items-center gap-2">

                           <span
                               class="font-mono text-xs font-semibold
                                   tracking-wide text-[#67e8f9]">
                               {{ $case->case_number }}
                           </span>

                           <span class="text-slate-700">
                               /
                           </span>

                           <span class="truncate text-sm font-semibold text-white">
                               {{ $case->patient?->name ?? 'Unnamed Patient' }}
                           </span>

                       </div>


                       <div
                           class="mt-1 flex flex-wrap items-center gap-x-3
                               gap-y-1 text-[11px] text-slate-500">

                           <span>
                               {{ $case->patient?->patient_code ?? 'No patient code' }}
                           </span>

                           <span class="text-slate-700">
                               •
                           </span>

                           <span>
                               {{ $case->specialization ?: 'Specialization not specified' }}
                           </span>

                       </div>

                   </div>

               </div>


               <div class="flex items-center gap-2">

                   {{-- Case status --}}
                   @if ($case->status === 'completed')
                       <span
                           class="inline-flex items-center gap-2
                               rounded-lg border border-emerald-400/15
                               bg-emerald-400/[0.06]
                               px-3 py-2 text-[10px]
                               font-semibold uppercase tracking-[0.12em]
                               text-emerald-400">
                           <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                           Completed
                       </span>
                   @elseif ($case->status === 'processing')
                       <span
                           class="inline-flex items-center gap-2
                               rounded-lg border border-[#06B6D4]/20
                               bg-[#06B6D4]/[0.06]
                               px-3 py-2 text-[10px]
                               font-semibold uppercase tracking-[0.12em]
                               text-[#67e8f9]">
                           <span class="h-1.5 w-1.5 rounded-full bg-[#06B6D4]"></span>
                           Processing
                       </span>
                   @else
                       <span
                           class="inline-flex items-center gap-2
                               rounded-lg border border-amber-400/15
                               bg-amber-400/[0.05]
                               px-3 py-2 text-[10px]
                               font-semibold uppercase tracking-[0.12em]
                               text-amber-400">
                           <span class="h-1.5 w-1.5 rounded-full bg-amber-400"></span>
                           Pending
                       </span>
                   @endif


                   <a href="{{ route('cases.edit', $case) }}"
                       class="inline-flex h-9 items-center justify-center
                           rounded-lg border border-white/[0.08]
                           bg-white/[0.03] px-4
                           text-xs font-semibold text-slate-300
                           transition hover:border-[#06B6D4]/25
                           hover:text-white">
                       Edit Case
                   </a>

               </div>

           </div>


           {{-- =====================================================
            MAIN WORKSTATION
        ====================================================== --}}

           <div class="grid gap-3
                   xl:grid-cols-[220px_minmax(0,1fr)_350px]">
               @include('cases.partials.workspace.slides-sidebar')


                @include('cases.partials.workspace.viewer')

                @include('cases.partials.workspace.analysis-sidebar')
              </div>
            
       </section>
             
   @else
       {{-- =====================================================
        EMPTY WSI STATE
    ====================================================== --}}

       <section
           class="mt-6 overflow-hidden rounded-2xl
               border border-dashed border-white/[0.08]
               bg-[#050B14]/60">

           <div class="flex min-h-[300px]
                   items-center justify-center px-6 py-12">

               <div class="max-w-md text-center">

                   <div
                       class="mx-auto flex h-12 w-12
                           items-center justify-center
                           rounded-2xl border
                           border-[#06B6D4]/15
                           bg-[#06B6D4]/[0.05]
                           text-[#06B6D4]">
                       <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                           stroke-width="1.7">
                           <path d="M6 3h9l3 3v15H6z" />
                           <path d="M15 3v4h4" />
                       </svg>
                   </div>

                   <h3 class="mt-4 text-sm font-semibold text-white">
                       No digital slide available
                   </h3>

                   <p class="mx-auto mt-2 max-w-sm
                           text-xs leading-5 text-slate-500">
                       Upload a TIFF whole-slide image to begin
                       digital pathology review.
                   </p>

               </div>

           </div>

       </section>

   @endif
