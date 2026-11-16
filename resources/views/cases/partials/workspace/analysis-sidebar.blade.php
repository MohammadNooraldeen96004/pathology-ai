{{-- =========================================================
    RIGHT — ANALYSIS SIDEBAR
========================================================== --}}

<aside
    class="overflow-hidden rounded-2xl
           border border-white/[0.07]
           bg-[#050B14]
           xl:sticky xl:top-24">


    {{-- =====================================================
        SIDEBAR HEADER
    ====================================================== --}}
    <div class="border-b border-white/[0.07] px-5 py-4">

        <div class="flex items-start justify-between gap-4">

            <div class="min-w-0">

                <p
                    class="text-[9px] font-semibold uppercase
                           tracking-[0.18em] text-[#67e8f9]/60">
                    Analysis Workspace
                </p>

                <h3 class="mt-1 text-sm font-bold text-white">
                    Slide Assessment
                </h3>

                <p class="mt-2 truncate font-mono
                           text-[10px] text-slate-600"
                    x-text="activeSlide?.name ?? 'No slide selected'">
                </p>

            </div>


            @if ($case->status === 'completed')
                <span
                    class="shrink-0 rounded-full
                           border border-emerald-400/15
                           bg-emerald-400/[0.06]
                           px-2.5 py-1
                           text-[9px] font-semibold uppercase
                           tracking-[0.12em]
                           text-emerald-400">
                    Read Only
                </span>
            @endif

        </div>

    </div>


    {{-- =====================================================
        AI ANALYSIS
    ====================================================== --}}
    <section class="border-b border-white/[0.07] px-5 py-5">

        {{-- Heading --}}
        <div class="flex items-start justify-between gap-4">

            <div>

                <p
                    class="text-[9px] font-semibold uppercase
                           tracking-[0.16em] text-violet-300/80">
                    Model Output
                </p>

                <h4 class="mt-1 text-sm font-bold text-white">
                    AI Analysis
                </h4>

            </div>


            {{-- Not started --}}
            <span x-show="activeSlide && !activeAnalysis"
                class="rounded-full border border-white/[0.07]
                       bg-white/[0.03]
                       px-2.5 py-1
                       text-[9px] font-semibold uppercase
                       tracking-[0.12em] text-slate-500">

                Not Started

            </span>


            {{-- Pending --}}
            <span x-show="activeAnalysis?.status === 'pending'" x-cloak
                class="rounded-full border border-amber-400/15
                       bg-amber-400/[0.05]
                       px-2.5 py-1
                       text-[9px] font-semibold uppercase
                       tracking-[0.12em] text-amber-300">

                Pending

            </span>


            {{-- Processing --}}
            <span x-show="activeAnalysis?.status === 'processing'" x-cloak
                class="inline-flex items-center gap-1.5
                       rounded-full border border-violet-400/15
                       bg-violet-400/[0.05]
                       px-2.5 py-1
                       text-[9px] font-semibold uppercase
                       tracking-[0.12em] text-violet-300">

                <span class="app-soft-pulse h-1.5 w-1.5 rounded-full bg-violet-300
                           ">
                </span>

                Processing

            </span>


            {{-- Completed --}}
            <span x-show="activeAnalysis?.status === 'completed'" x-cloak
                class="inline-flex items-center gap-1.5
                       rounded-full border border-[#06B6D4]/15
                       bg-[#06B6D4]/[0.06]
                       px-2.5 py-1
                       text-[9px] font-semibold uppercase
                       tracking-[0.12em] text-[#67e8f9]">

                <span class="h-1.5 w-1.5 rounded-full
                           bg-[#06B6D4]">
                </span>

                Completed

            </span>

        </div>


        {{-- No active slide --}}
        <div x-show="!activeSlide"
            class="mt-4 rounded-xl
                   border border-dashed border-white/[0.07]
                   bg-white/[0.015] p-4">

            <p class="text-xs leading-5 text-slate-500">
                Select a pathology slide to view its AI analysis.
            </p>

        </div>


        {{-- No analysis yet --}}
        <div x-show="activeSlide && !activeAnalysis"
            class="mt-4 rounded-xl
                   border border-white/[0.06]
                   bg-[#07111D]/50 p-4">

            <p class="text-xs font-medium text-slate-300">
                No analysis available
            </p>

            <p class="mt-1.5 text-[10px] leading-5 text-slate-600">
                Run the pathology model to generate an assessment
                for the selected slide.
            </p>

        </div>


        {{-- =================================================
            RUN AI
        ================================================== --}}
        @if ($case->status !== 'completed')
            <form
                x-show="
        activeSlide &&
        (
            !activeAnalysis ||
            activeAnalysis.status === 'pending'
        )
    "
                x-cloak x-data="{ analysisSubmitting: false }" @submit="analysisSubmitting = true" method="POST"
                :action="activeSlide?.runAnalysisUrl" class="mt-4">
                @csrf

                <button type="submit" :disabled="analysisSubmitting"
                    class="inline-flex w-full items-center justify-center
               gap-2 rounded-xl
               bg-[#06B6D4]
               px-4 py-3
               text-xs font-bold text-[#030914]
               transition duration-200
               hover:-translate-y-0.5
               hover:brightness-110
               hover:shadow-[0_0_22px_rgba(6,182,212,0.18)]
               disabled:cursor-wait
               disabled:opacity-70">

                    <span x-show="!analysisSubmitting" class="inline-flex items-center gap-2">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.8">
                            <path d="M8 5v14l11-7z" />
                        </svg>

                        Run AI Analysis
                    </span>


                    <span x-show="analysisSubmitting" x-cloak class="inline-flex items-center gap-2">
                        <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="9" stroke="currentColor"
                                stroke-width="3" />

                            <path class="opacity-75" fill="currentColor" d="M12 3a9 9 0 00-9 9h3a6 6 0 016-6V3z" />
                        </svg>

                        Analyzing Slide...
                    </span>

                </button>
            </form>
        @endif

        {{-- =================================================
            ANALYSIS RESULT
        ================================================== --}}
        <div x-show="
                activeAnalysis &&
                activeAnalysis.status === 'completed'
            "
            x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="mt-5">

            {{-- Prediction --}}
            <div
                class="relative overflow-hidden
                    app-card-soft rounded-xl border border-white/[0.06] 
                       rounded-2xl
                       border border-violet-400/10
                       bg-violet-400/[0.035]
                       p-4">

                <div
                    class="pointer-events-none absolute
                           -right-10 -top-10
                           h-24 w-24 rounded-full
                           bg-violet-400/[0.06]
                           blur-3xl">
                </div>


                <div class="relative">

                    <p
                        class="text-[9px] font-semibold uppercase
                               tracking-[0.15em] text-slate-600">
                        Model Assessment
                    </p>

                    <p class="mt-2 text-xl font-bold tracking-tight text-white"
                        x-text="activeAnalysis?.prediction ?? '—'">
                    </p>


                    <div x-show="
                            activeAnalysis?.score !== null &&
                            activeAnalysis?.score !== undefined
                        "
                        class="mt-4 flex items-end justify-between
                               border-t border-white/[0.06]
                               pt-4">

                        <span class="text-[10px] text-slate-600">
                            Model Score
                        </span>

                        <span class="font-mono text-lg font-bold text-[#67e8f9]"
                            x-text="
                                (
                                    Number(activeAnalysis?.score) * 100
                                ).toFixed(1) + '%'
                            ">
                        </span>

                    </div>

                </div>

            </div>


            {{-- Metadata --}}
            <dl
                class="mt-4 divide-y divide-white/[0.05]
                       rounded-xl border border-white/[0.06]
                       bg-white/[0.015]
                       px-4">

                <div x-show="activeAnalysis?.modelVersion" class="flex items-center justify-between gap-4 py-3">

                    <dt class="text-[10px] text-slate-600">
                        Model
                    </dt>

                    <dd class="max-w-[180px] truncate
                               text-right font-mono
                               text-[10px] text-slate-400"
                        x-text="activeAnalysis?.modelVersion">
                    </dd>

                </div>


                <div x-show="activeAnalysis?.analyzedAt" class="flex items-center justify-between gap-4 py-3">

                    <dt class="text-[10px] text-slate-600">
                        Analyzed
                    </dt>

                    <dd class="text-right text-[10px] text-slate-400" x-text="formatDate(activeAnalysis?.analyzedAt)">
                    </dd>

                </div>

            </dl>

        </div>

    </section>


    {{-- =====================================================
        DOCTOR REVIEW
    ====================================================== --}}
    <section class="px-5 py-5">

        {{-- Heading --}}
        <div class="flex items-start justify-between gap-4">

            <div>

                <p
                    class="text-[9px] font-semibold uppercase
                           tracking-[0.16em] text-emerald-300/80">
                    Clinical Assessment
                </p>

                <h4 class="mt-1 text-sm font-bold text-white">
                    Doctor Review
                </h4>

            </div>


            {{-- Not reviewed --}}
            <span x-show="activeSlide && !activeReview"
                class="rounded-full border border-white/[0.07]
                       bg-white/[0.03]
                       px-2.5 py-1
                       text-[9px] font-semibold uppercase
                       tracking-[0.12em] text-slate-500">

                Not Reviewed

            </span>


            {{-- Reviewed --}}
            <span x-show="activeReview" x-cloak x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="inline-flex items-center gap-1.5
                       rounded-full border border-emerald-400/15
                       bg-emerald-400/[0.06]
                       px-2.5 py-1
                       text-[9px] font-semibold uppercase
                       tracking-[0.12em] text-emerald-400">

                <span class="h-1.5 w-1.5 rounded-full
                           bg-emerald-400">
                </span>

                Reviewed

            </span>

        </div>


        {{-- AI not ready --}}
        <div x-show="
                activeSlide &&
                (
                    !activeAnalysis ||
                    activeAnalysis.status !== 'completed'
                )
            "
            class="mt-4 rounded-xl
                   border border-amber-400/10
                   bg-amber-400/[0.035]
                   p-4">

            <p class="text-xs font-medium text-amber-300">
                Review unavailable
            </p>

            <p class="mt-1.5 text-[10px] leading-5 text-slate-600">
                Complete AI analysis for this slide before submitting
                the clinical review.
            </p>

        </div>


        {{-- =================================================
            EXISTING REVIEW
        ================================================== --}}
        <div x-show="activeReview" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" x-cloak class="mt-5">

            <div
                class="rounded-2xl
                       border border-emerald-400/10
                       bg-emerald-400/[0.035]
                       p-4">

                <p
                    class="text-[9px] font-semibold uppercase
                           tracking-[0.15em] text-slate-600">
                    Clinical Decision
                </p>

                <p class="mt-2 text-lg font-bold capitalize text-white" x-text="activeReview?.decision ?? '—'">
                </p>

            </div>


            <div x-show="activeReview?.notes"
                class="mt-4 rounded-xl
                       border border-white/[0.06]
                       bg-white/[0.015]
                       p-4">

                <p
                    class="text-[9px] font-semibold uppercase
                           tracking-[0.14em] text-slate-600">
                    Review Notes
                </p>

                <p class="mt-2 whitespace-pre-line
                           text-xs leading-6 text-slate-400"
                    x-text="activeReview?.notes">
                </p>

            </div>


            <div x-show="activeReview?.reviewedAt"
                class="mt-4 flex items-center justify-between
                       border-t border-white/[0.05]
                       pt-3">

                <span class="text-[10px] text-slate-600">
                    Reviewed
                </span>

                <span class="text-right text-[10px] text-slate-500" x-text="formatDate(activeReview?.reviewedAt)">
                </span>

            </div>

        </div>


        {{-- =================================================
    REVIEW FORM
================================================== --}}
        @if ($case->status !== 'completed')
            <form
                x-show="
            activeSlide &&
            activeAnalysis &&
            activeAnalysis.status === 'completed' &&
            !activeReview
        "
                x-cloak x-data="{ reviewSubmitting: false }" @submit="reviewSubmitting = true"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" method="POST" :action="activeSlide?.reviewUrl" class="mt-5">

                @csrf
                @method('PUT')


                {{-- Decision --}}
                <div>

                    <label
                        class="text-[9px] font-semibold uppercase
                       tracking-[0.14em] text-slate-500">
                        Clinical Decision
                    </label>


                    <div class="mt-3 space-y-2">

                        {{-- Benign --}}
                        <label
                            class="flex cursor-pointer items-center gap-3
                           rounded-xl border border-white/[0.06]
                           bg-white/[0.02]
                           px-3 py-3
                           transition duration-200
                           hover:-translate-y-0.5
                           hover:border-emerald-400/20
                           hover:bg-emerald-400/[0.025]">

                            <input type="radio" name="decision" value="benign" x-model="reviewDecision"
                                class="border-white/20
                               bg-[#07111D]
                               text-emerald-400
                               focus:ring-emerald-400/20">

                            <div>

                                <p class="text-xs font-semibold text-slate-300">
                                    Benign
                                </p>

                                <p class="mt-0.5 text-[9px] text-slate-600">
                                    No malignant assessment
                                </p>

                            </div>

                        </label>


                        {{-- Suspicious --}}
                        <label
                            class="flex cursor-pointer items-center gap-3
                           rounded-xl border border-white/[0.06]
                           bg-white/[0.02]
                           px-3 py-3
                           transition duration-200
                           hover:-translate-y-0.5
                           hover:border-amber-400/20
                           hover:bg-amber-400/[0.025]">

                            <input type="radio" name="decision" value="suspicious" x-model="reviewDecision"
                                class="border-white/20
                               bg-[#07111D]
                               text-amber-400
                               focus:ring-amber-400/20">

                            <div>

                                <p class="text-xs font-semibold text-slate-300">
                                    Suspicious
                                </p>

                                <p class="mt-0.5 text-[9px] text-slate-600">
                                    Requires further clinical interpretation
                                </p>

                            </div>

                        </label>


                        {{-- Malignant --}}
                        <label
                            class="flex cursor-pointer items-center gap-3
                           rounded-xl border border-white/[0.06]
                           bg-white/[0.02]
                           px-3 py-3
                           transition duration-200
                           hover:-translate-y-0.5
                           hover:border-red-400/20
                           hover:bg-red-400/[0.025]">

                            <input type="radio" name="decision" value="malignant" x-model="reviewDecision"
                                class="border-white/20
                               bg-[#07111D]
                               text-red-400
                               focus:ring-red-400/20">

                            <div>

                                <p class="text-xs font-semibold text-slate-300">
                                    Malignant
                                </p>

                                <p class="mt-0.5 text-[9px] text-slate-600">
                                    Malignant interpretation
                                </p>

                            </div>

                        </label>

                    </div>

                </div>


                {{-- Notes --}}
                <div class="mt-5">

                    <label for="review_notes"
                        class="text-[9px] font-semibold uppercase
                       tracking-[0.14em] text-slate-500">
                        Review Notes
                    </label>

                    <textarea id="review_notes" name="notes" rows="4" maxlength="5000" x-model="reviewNotes"
                        placeholder="Add clinical review notes..."
                        class="mt-2 w-full resize-y
                       rounded-xl border border-white/[0.08]
                       bg-[#07111D]
                       px-3 py-3 text-xs leading-5
                       text-slate-300
                       placeholder:text-slate-700
                       focus:border-[#06B6D4]/40
                       focus:ring-[#06B6D4]/10"></textarea>

                </div>


                {{-- Validation --}}
                @error('decision')
                    <p class="mt-2 text-xs text-red-400">
                        {{ $message }}
                    </p>
                @enderror


                @error('notes')
                    <p class="mt-2 text-xs text-red-400">
                        {{ $message }}
                    </p>
                @enderror


                {{-- Submit --}}
                <button type="submit" :disabled="!reviewDecision || reviewSubmitting"
                    class="mt-4 inline-flex w-full
                   items-center justify-center gap-2
                   rounded-xl bg-emerald-400
                   px-4 py-3
                   text-xs font-bold text-[#030914]
                   transition duration-200
                   hover:-translate-y-0.5
                   hover:brightness-110
                   hover:shadow-[0_0_20px_rgba(52,211,153,0.12)]
                   disabled:cursor-not-allowed
                   disabled:opacity-40">

                    <span x-show="!reviewSubmitting">
                        Submit Review
                    </span>


                    <span x-show="reviewSubmitting" x-cloak class="inline-flex items-center gap-2">

                        <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">

                            <circle class="opacity-25" cx="12" cy="12" r="9" stroke="currentColor"
                                stroke-width="3" />

                            <path class="opacity-75" fill="currentColor" d="M12 3a9 9 0 00-9 9h3a6 6 0 016-6V3z" />

                        </svg>

                        Saving Review...

                    </span>

                </button>

            </form>
        @endif

    </section>

</aside>
