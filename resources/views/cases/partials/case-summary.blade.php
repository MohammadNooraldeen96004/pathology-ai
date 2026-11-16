{{-- =========================================================
    CASE OVERVIEW
========================================================== --}}

<section class="app-panelapp-card-hover relative overflow-hidden p-6 sm:p-8">

    {{-- Background glow --}}
    <div
        class="pointer-events-none absolute -right-24 -top-24
               h-72 w-72 rounded-full
               bg-[#06B6D4]/[0.07] blur-[90px]">
    </div>


    <div class="relative">

        {{-- =====================================================
            TOP
        ====================================================== --}}
        <div class="grid grid-cols-1 gap-8 xl:grid-cols-[1.35fr_.65fr]">

            {{-- =================================================
                PATIENT
            ================================================== --}}
            <div>

                <div class="flex items-start justify-between gap-5">

                    <div>

                        <div
                            class="text-[10px] font-semibold uppercase
                                   tracking-[0.18em] text-[#67e8f9]/70">
                            Patient
                        </div>

                        <h2 class="mt-2 text-2xl font-bold tracking-tight text-white">
                            {{ $case->patient?->name ?? 'Unnamed Patient' }}
                        </h2>

                        <p class="mt-1 font-mono text-xs text-slate-500">
                            {{ $case->patient?->patient_code ?? 'No patient code' }}
                        </p>

                    </div>


                    <div
                        class="flex h-12 w-12 shrink-0 items-center justify-center
                               rounded-2xl border border-[#06B6D4]/20
                               bg-[#06B6D4]/10
                               text-lg font-bold text-[#06B6D4]">

                        {{ strtoupper(substr($case->patient?->name ?? 'P', 0, 1)) }}

                    </div>

                </div>


                {{-- Patient / case metadata --}}
                <div class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-4">

                    {{-- Age --}}
                    <div
                        class="rounded-xl border border-white/[0.06]
                               bg-white/[0.025] p-4">

                        <p
                            class="text-[9px] font-semibold uppercase
                                   tracking-[0.14em] text-slate-600">
                            Age
                        </p>

                        <p class="mt-2 text-sm font-semibold text-slate-200">
                            {{ $case->patient?->age !== null
                                ? $case->patient->age . ' yrs'
                                : '—' }}
                        </p>

                    </div>


                    {{-- Gender --}}
                    <div
                        class="rounded-xl border border-white/[0.06]
                               bg-white/[0.025] p-4">

                        <p
                            class="text-[9px] font-semibold uppercase
                                   tracking-[0.14em] text-slate-600">
                            Gender
                        </p>

                        <p class="mt-2 text-sm font-semibold text-slate-200">
                            {{ $case->patient?->gender ?? '—' }}
                        </p>

                    </div>


                    {{-- Slides --}}
                    <div
                        class="rounded-xl border border-white/[0.06]
                               bg-white/[0.025] p-4">

                        <p
                            class="text-[9px] font-semibold uppercase
                                   tracking-[0.14em] text-slate-600">
                            Slides
                        </p>

                        <p class="mt-2 text-sm font-semibold text-white">
                            {{ $case->slides->count() }}
                            <span class="font-normal text-slate-600">
                                / {{ $case->expected_slides }}
                            </span>
                        </p>

                    </div>


                    {{-- Created --}}
                    <div
                        class="rounded-xl border border-white/[0.06]
                               bg-white/[0.025] p-4">

                        <p
                            class="text-[9px] font-semibold uppercase
                                   tracking-[0.14em] text-slate-600">
                            Created
                        </p>

                        <p class="mt-2 text-sm font-semibold text-slate-200">
                            {{ $case->created_at->format('M d, Y') }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- =================================================
                CASE DETAILS
            ================================================== --}}
            <div
                class="rounded-2xl border border-white/[0.07]
                       bg-[#07111D]/65 p-5">

                <div class="flex items-start justify-between gap-4">

                    <div>

                        <p
                            class="text-[10px] font-semibold uppercase
                                   tracking-[0.17em] text-slate-600">
                            Clinical Case
                        </p>

                        <p class="mt-2 font-mono text-lg font-bold text-[#06B6D4]">
                            {{ $case->case_number }}
                        </p>

                    </div>


                    <x-status-badge :status="$case->status" />

                </div>


                <dl class="mt-6 space-y-4">

                    {{-- Specialization --}}
                    <div
                        class="flex items-start justify-between gap-5
                               border-t border-white/[0.06] pt-4">

                        <dt class="text-xs text-slate-600">
                            Specialization
                        </dt>

                        <dd
                            class="max-w-[190px] text-right
                                   text-xs font-medium text-slate-300">

                            {{ $case->specialization ?: 'Not specified' }}

                        </dd>

                    </div>


                    {{-- ICD-10 --}}
                    <div
                        class="flex items-start justify-between gap-5
                               border-t border-white/[0.06] pt-4">

                        <dt class="text-xs text-slate-600">
                            ICD-10
                        </dt>

                        <dd
                            class="font-mono text-xs font-semibold
                                   text-violet-300">

                            {{ $case->icd10 ?: '—' }}

                        </dd>

                    </div>


                    {{-- Slide progress --}}
                    <div
                        class="flex items-start justify-between gap-5
                               border-t border-white/[0.06] pt-4">

                        <dt class="text-xs text-slate-600">
                            Slide Progress
                        </dt>

                        <dd class="text-xs font-medium text-slate-300">

                            {{ $case->slides->count() }}
                            of
                            {{ $case->expected_slides }}

                        </dd>

                    </div>

                </dl>

            </div>

        </div>


        {{-- =====================================================
            CLINICAL INFORMATION
        ====================================================== --}}
        <div class="mt-8 border-t border-white/[0.06] pt-6">

            <div class="mb-4">

                <div
                    class="text-[10px] font-semibold uppercase
                           tracking-[0.17em] text-slate-600">
                    Clinical Intake
                </div>

                <h3 class="mt-1 text-sm font-bold text-white">
                    Clinical Information
                </h3>

            </div>


            <div
                class="rounded-xl border border-white/[0.06]
                       bg-[#07111D]/45 p-5">

                @if ($case->additional_info)

                    <p
                        class="whitespace-pre-line
                               text-sm leading-7 text-slate-300">
                        {{ $case->additional_info }}
                    </p>

                @else

                    <p class="text-sm italic text-slate-600">
                        No clinical information provided.
                    </p>

                @endif

            </div>

        </div>

    </div>

</section>