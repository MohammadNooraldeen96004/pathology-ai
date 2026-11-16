<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

            <div class="app-panel app-panel-hover app-fade-up">

                <div
                    class="mb-2 flex items-center gap-2 text-[11px] font-medium uppercase tracking-[0.18em] text-[#06B6D4]/80">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#06B6D4] shadow-[0_0_10px_rgba(6,182,212,.8)]"></span>
                    Clinical Workspace
                </div>

                <h1 class="app-heading-accent text-3xl font-extrabold tracking-tight sm:text-4xl">
                    Clinical Dashboard
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-400">
                    Review active pathology cases, monitor progress, and continue your diagnostic workflow.
                </p>

            </div>


            <div class="app-panel app-card-hover app-panel-hover app-fade-up app-delay-1">

                <a href="{{ route('cases.index') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-white/10 bg-white/[0.025] px-4 py-2.5 text-sm font-medium text-slate-300 transition hover:border-white/15 hover:bg-white/[0.05] hover:text-white">
                    View All Cases
                </a>

                <a href="{{ route('cases.create') }}"
                    class="group inline-flex items-center justify-center gap-2 rounded-xl bg-[#06B6D4] px-5 py-2.5 text-sm font-bold text-[#030914] shadow-[0_0_24px_rgba(6,182,212,0.16)] transition duration-300 hover:-translate-y-0.5 hover:shadow-[0_0_32px_rgba(6,182,212,0.30)]">
                    <span class="text-lg leading-none transition group-hover:rotate-90">+</span>
                    New Case
                </a>

            </div>

        </div>

    </x-slot>


    <div class="py-10 sm:py-12">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- =========================
                OVERVIEW CARDS
            ========================== --}}

            <div class="grid grid-cols-1 gap-5 md:grid-cols-3">

                {{-- Active --}}
                <div class="app-panel app-panel-hover app-card-hover group relative overflow-hidden p-6">

                    <div
                        class="pointer-events-none absolute -right-16 -top-16 h-36 w-36 rounded-full bg-yellow-400/[0.05] blur-3xl transition duration-500 group-hover:bg-yellow-400/[0.09]">
                    </div>

                    <div class="relative">

                        <div class="flex items-start justify-between">

                            <div>
                                <p class="text-xs font-medium uppercase tracking-[0.14em] text-slate-500">
                                    Active Cases
                                </p>

                                <p class="mt-3 text-4xl font-extrabold tracking-tight text-white">
                                    {{$activeCasesCount}}
                                </p>
                            </div>

                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-xl border border-yellow-400/15 bg-yellow-400/[0.06]">
                                <span
                                    class="h-2.5 w-2.5 rounded-full bg-yellow-400 shadow-[0_0_12px_rgba(250,204,21,.65)]"></span>
                            </div>

                        </div>

                        <div class="mt-5 flex items-center gap-2 text-xs text-slate-500">
                            <span class="font-medium text-yellow-400/90">In Progress</span>
                            <span>clinical cases</span>
                        </div>

                    </div>

                </div>


                {{-- AI --}}
                <div class="app-panel app-card-hover app-panel-hover group relative overflow-hidden p-6">

                    <div
                        class="pointer-events-none absolute -right-16 -top-16 h-40 w-40 rounded-full bg-[#06B6D4]/[0.08] blur-3xl transition duration-500 group-hover:bg-[#06B6D4]/[0.13]">
                    </div>

                    <div class="relative">

                        <div class="flex items-start justify-between">

                            <div>
                                <p class="text-xs font-medium uppercase tracking-[0.14em] text-[#67e8f9]/80">
                                    Slides Awaiting AI
                                </p>

                                <p class="mt-3 text-4xl font-extrabold tracking-tight text-white">
                                   {{ $slidesAwaitingAiCount }}
                                </p>
                            </div>

                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-xl border border-[#06B6D4]/20 bg-[#06B6D4]/10">
                                <svg class="h-5 w-5 text-[#06B6D4]" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.7">
                                    <path d="M12 3v3M12 18v3M3 12h3M18 12h3" />
                                    <circle cx="12" cy="12" r="4.5" />
                                </svg>
                            </div>

                        </div>

                        <div class="mt-5 text-xs text-slate-500">
                            Awaiting future slide processing
                        </div>

                    </div>

                </div>


                {{-- Completed --}}
                <div class="app-panel app-card-hover app-panel-hover group relative overflow-hidden p-6">

                    <div
                        class="pointer-events-none absolute -right-16 -top-16 h-36 w-36 rounded-full bg-emerald-400/[0.05] blur-3xl transition duration-500 group-hover:bg-emerald-400/[0.09]">
                    </div>

                    <div class="relative">

                        <div class="flex items-start justify-between">

                            <div>
                                <p class="text-xs font-medium uppercase tracking-[0.14em] text-slate-500">
                                    Completed Reports
                                </p>

                                <p class="mt-3 text-4xl font-extrabold tracking-tight text-white">
                                    {{ $completedCasesCount }}
                                </p>
                            </div>

                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-xl border border-emerald-400/15 bg-emerald-400/[0.06]">
                                <svg class="h-5 w-5 text-emerald-400" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.7">
                                    <path d="M5 12.5l4 4L19 7" />
                                </svg>
                            </div>

                        </div>

                        <div class="mt-5 flex items-center gap-2 text-xs text-slate-500">
                            <span class="font-medium text-emerald-400/90">Completed</span>
                            <span>clinical workflows</span>
                        </div>

                    </div>

                </div>

            </div>


            {{-- =========================
                MAIN CONTENT
            ========================== --}}

            <div class="mt-8 grid grid-cols-1 gap-6 xl:grid-cols-[1fr_320px]">

                {{-- Recent Cases --}}
                <section class="app-panel app-card-hover overflow-hidden">

                    <div
                        class="flex flex-col gap-4 border-b border-white/[0.06] px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                        <div>
                            <h2 class="text-lg font-bold text-white">
                                Recent Patient Cases
                            </h2>

                            <p class="mt-1 text-xs text-slate-500">
                                Continue your latest clinical work.
                            </p>
                        </div>

                        <a href="{{ route('cases.index') }}"
                            class="inline-flex items-center gap-2 text-sm font-medium text-[#06B6D4] transition hover:text-cyan-300">
                            View All Cases
                            <span>→</span>
                        </a>

                    </div>


                    <div class="overflow-x-auto">

                        <table class="w-full text-left text-sm text-slate-400">

                            <thead
                                class="border-b border-white/[0.05] bg-white/[0.015] text-[11px] uppercase tracking-[0.12em] text-slate-500">

                                <tr>
                                    <th class="px-6 py-4 font-medium">Case</th>
                                    <th class="px-6 py-4 font-medium">Patient</th>
                                    <th class="px-6 py-4 font-medium">Date</th>
                                    <th class="px-6 py-4 font-medium">Slides</th>
                                    <th class="px-6 py-4 font-medium">Status</th>
                                    <th class="px-6 py-4 text-right font-medium">Action</th>
                                </tr>

                            </thead>


                            <tbody class="divide-y divide-white/[0.05]">

                                @forelse ($cases as $case)
                                    <tr class="group transition duration-200 hover:bg-white/[0.025]">

                                        {{-- Case --}}
                                        <td class="px-6 py-5">

                                            <div class="font-mono text-sm font-semibold text-[#06B6D4]">
                                                {{ $case->case_number }}
                                            </div>

                                        </td>


                                        {{-- Patient --}}
                                        <td class="px-6 py-5">

                                            @if ($case->patient)
                                                <div class="font-semibold text-white">
                                                    {{ $case->patient->name ?? 'Unnamed Patient' }}
                                                </div>

                                                <div class="mt-1 text-xs text-slate-500">
                                                    {{ $case->patient->patient_code ?? '-' }}
                                                    • {{ $case->patient->gender ?? '-' }}
                                                    • {{ $case->patient->age ?? '-' }} yrs
                                                </div>
                                            @else
                                                <div class="text-sm text-red-400">
                                                    Patient record missing
                                                </div>
                                            @endif

                                        </td>


                                        {{-- Date --}}
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            {{ $case->created_at->format('M d, Y') }}
                                        </td>


                                        {{-- Slides --}}
                                        <td class="px-6 py-5">

                                            <span
                                                class="inline-flex items-center rounded-lg border border-white/[0.08] bg-white/[0.035] px-2.5 py-1 text-xs text-slate-300">
                                                {{ $case->slides_count }}
                                                {{ $case->slides_count === 1 ? 'slide' : 'slides' }}
                                            </span>

                                        </td>


                                        {{-- Status --}}
                                        <td class="px-6 py-5">
                                            <x-status-badge :status="$case->status" />
                                        </td>


                                        {{-- Action --}}
                                        <td class="px-6 py-5 text-right">

                                            <a href="{{ route('cases.show', $case) }}"
                                                class="inline-flex items-center gap-2 font-medium text-[#8B5CF6] transition duration-200 group-hover:translate-x-0.5 hover:text-violet-300">
                                                Open Workspace
                                                <span>→</span>
                                            </a>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="6" class="px-6 py-16 text-center">

                                            <div class="text-base font-medium text-slate-300">
                                                No clinical cases yet.
                                            </div>

                                            <p class="mt-2 text-sm text-slate-500">
                                                Create your first pathology case to begin the clinical workflow.
                                            </p>

                                            <a href="{{ route('cases.create') }}"
                                                class="mt-5 inline-flex rounded-xl bg-[#06B6D4] px-5 py-2.5 text-sm font-bold text-[#030914] transition hover:brightness-110">
                                                Create First Case
                                            </a>

                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </section>


                {{-- Clinical workflow panel --}}
                <aside class="app-panel relative overflow-hidden p-6">

                    <div
                        class="pointer-events-none absolute -right-24 -top-24
               h-56 w-56 rounded-full
               bg-[#06B6D4]/[0.08]
               blur-[80px]">
                    </div>


                    <div class="relative">

                        {{-- Header --}}
                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-11 w-11 items-center justify-center
                       rounded-xl border border-[#06B6D4]/20
                       bg-[#06B6D4]/10">

                                <svg class="h-5 w-5 text-[#06B6D4]" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.7">

                                    <path d="M9 3h6M10 3v5l-5 9a2 2 0 001.7 3h10.6A2 2 0 0019 17l-5-9V3" />
                                    <path d="M8 14h8" />

                                </svg>

                            </div>


                            <div>

                                <p
                                    class="text-[10px] font-semibold uppercase
                           tracking-[0.17em] text-[#67e8f9]/70">
                                    Clinical Workflow
                                </p>

                                <h3 class="mt-1 font-bold text-white">
                                    Pathology Pipeline
                                </h3>

                            </div>

                        </div>


                        <p class="mt-5 text-sm leading-6 text-slate-400">
                            Each clinical case moves through a structured pathology workflow
                            from intake to final diagnosis.
                        </p>


                        {{-- Stages --}}
                        <div class="mt-6 space-y-2">

                            {{-- 01 --}}
                            <div
                                class="flex items-start gap-3
                       rounded-xl border border-white/[0.06]
                       bg-white/[0.02] p-3.5">

                                <div
                                    class="flex h-8 w-8 shrink-0 items-center justify-center
                           rounded-lg border border-[#06B6D4]/15
                           bg-[#06B6D4]/[0.06]
                           font-mono text-[10px] font-bold text-[#67e8f9]">
                                    01
                                </div>

                                <div>

                                    <p class="text-xs font-semibold text-slate-200">
                                        Case Intake
                                    </p>

                                    <p class="mt-1 text-[10px] leading-5 text-slate-600">
                                        Register patient details, clinical information, and expected slides.
                                    </p>

                                </div>

                            </div>


                            {{-- 02 --}}
                            <div
                                class="flex items-start gap-3
                       rounded-xl border border-white/[0.06]
                       bg-white/[0.02] p-3.5">

                                <div
                                    class="flex h-8 w-8 shrink-0 items-center justify-center
                           rounded-lg border border-violet-400/15
                           bg-violet-400/[0.05]
                           font-mono text-[10px] font-bold text-violet-300">
                                    02
                                </div>

                                <div>

                                    <p class="text-xs font-semibold text-slate-200">
                                        AI Analysis
                                    </p>

                                    <p class="mt-1 text-[10px] leading-5 text-slate-600">
                                        Analyze pathology slides and generate the model assessment.
                                    </p>

                                </div>

                            </div>


                            {{-- 03 --}}
                            <div
                                class="flex items-start gap-3
                       rounded-xl border border-white/[0.06]
                       bg-white/[0.02] p-3.5">

                                <div
                                    class="flex h-8 w-8 shrink-0 items-center justify-center
                           rounded-lg border border-amber-400/15
                           bg-amber-400/[0.05]
                           font-mono text-[10px] font-bold text-amber-300">
                                    03
                                </div>

                                <div>

                                    <p class="text-xs font-semibold text-slate-200">
                                        Pathologist Review
                                    </p>

                                    <p class="mt-1 text-[10px] leading-5 text-slate-600">
                                        Review AI results and record the clinical slide assessment.
                                    </p>

                                </div>

                            </div>


                            {{-- 04 --}}
                            <div
                                class="flex items-start gap-3
                       rounded-xl border border-white/[0.06]
                       bg-white/[0.02] p-3.5">

                                <div
                                    class="flex h-8 w-8 shrink-0 items-center justify-center
                           rounded-lg border border-emerald-400/15
                           bg-emerald-400/[0.05]
                           font-mono text-[10px] font-bold text-emerald-300">
                                    04
                                </div>

                                <div>

                                    <p class="text-xs font-semibold text-slate-200">
                                        Final Report
                                    </p>

                                    <p class="mt-1 text-[10px] leading-5 text-slate-600">
                                        Complete the diagnostic documentation and finalize the case.
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- Footer --}}
                        <div class="mt-6 border-t border-white/[0.06] pt-5">

                            <a href="{{ route('cases.index') }}"
                                class="inline-flex items-center gap-2
                       text-sm font-medium text-slate-300
                       transition hover:text-white">

                                Open case management

                                <span class="text-[#06B6D4]">
                                    →
                                </span>

                            </a>

                        </div>

                    </div>

                </aside>

            </div>

        </div>

    </div>

</x-app-layout>
