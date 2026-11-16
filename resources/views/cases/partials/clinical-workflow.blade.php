{{-- =========================================================
    DIAGNOSTIC DOCUMENTATION
========================================================== --}}

<section class="app-panel overflow-hidden">

    {{-- Header --}}
    <div
        class="flex flex-col gap-3 border-b border-white/[0.06]
               px-5 py-4 sm:px-6
               lg:flex-row lg:items-center lg:justify-between">

        <div>

            <p
                class="text-[9px] font-semibold uppercase
                       tracking-[0.18em] text-[#67e8f9]/60">
                Pathology Documentation
            </p>

            <h2 class="mt-1 text-lg font-bold tracking-tight text-white">
                Diagnostic Documentation
            </h2>

            <p class="mt-1 text-xs text-slate-500">
                Pathology findings and final clinical interpretation.
            </p>

        </div>


        @if ($case->status === 'completed')

            <span
                class="inline-flex w-fit items-center gap-2
                       rounded-full border border-emerald-400/15
                       bg-emerald-400/[0.05]
                       px-2.5 py-1
                       text-[9px] font-semibold uppercase
                       tracking-[0.12em] text-emerald-400">

                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>

                Finalized

            </span>

        @else

            <a
                href="{{ route('cases.edit', $case) }}"
                class="inline-flex w-fit items-center justify-center
                       rounded-xl border border-white/[0.08]
                       bg-white/[0.03]
                       px-3.5 py-2
                       text-[11px] font-semibold text-slate-300
                       transition duration-200
                       hover:border-[#06B6D4]/25
                       hover:bg-[#06B6D4]/[0.05]
                       hover:text-[#67e8f9]">

                Update Documentation

            </a>

        @endif

    </div>


    <div class="space-y-3 p-5 sm:p-6">

        {{-- Grossing + Microscopy --}}
        <div class="grid grid-cols-1 items-start gap-3 lg:grid-cols-2">

            {{-- Grossing --}}
            <article
                class="rounded-xl border border-white/[0.06]
                       bg-[#07111D]/40 p-4">

                <div class="flex items-center gap-3">

                    <div
                        class="flex h-8 w-8 shrink-0 items-center justify-center
                               rounded-lg border border-white/[0.07]
                               bg-white/[0.03]
                               font-mono text-[10px] font-semibold
                               text-slate-500">
                        01
                    </div>

                    <div>
                        <p
                            class="text-[8px] font-semibold uppercase
                                   tracking-[0.15em] text-slate-600">
                            Macroscopic
                        </p>

                        <h3 class="mt-0.5 text-sm font-bold text-white">
                            Grossing
                        </h3>
                    </div>

                </div>


                <div class="mt-3 border-t border-white/[0.05] pt-3">

                    @if ($case->grossing)

                        <p class="whitespace-pre-line break-words text-sm leading-6 text-slate-300">
                            {{ $case->grossing }}
                        </p>

                    @else

                        <p class="text-xs italic text-slate-600">
                            No grossing documentation recorded.
                        </p>

                    @endif

                </div>

            </article>


            {{-- Microscopy --}}
            <article
                class="rounded-xl border border-white/[0.06]
                       bg-[#07111D]/40 p-4">

                <div class="flex items-center gap-3">

                    <div
                        class="flex h-8 w-8 shrink-0 items-center justify-center
                               rounded-lg border border-white/[0.07]
                               bg-white/[0.03]
                               font-mono text-[10px] font-semibold
                               text-slate-500">
                        02
                    </div>

                    <div>
                        <p
                            class="text-[8px] font-semibold uppercase
                                   tracking-[0.15em] text-slate-600">
                            Microscopic
                        </p>

                        <h3 class="mt-0.5 text-sm font-bold text-white">
                            Microscopy
                        </h3>
                    </div>

                </div>


                <div class="mt-3 border-t border-white/[0.05] pt-3">

                    @if ($case->micro_protocol)

                        <p class="whitespace-pre-line break-words text-sm leading-6 text-slate-300">
                            {{ $case->micro_protocol }}
                        </p>

                    @else

                        <p class="text-xs italic text-slate-600">
                            No microscopy documentation recorded.
                        </p>

                    @endif

                </div>

            </article>

        </div>


        {{-- Differential Diagnosis --}}
        <article
            class="rounded-xl border border-amber-400/[0.08]
                   bg-amber-400/[0.02] p-4">

            <div class="flex items-center gap-3">

                <div
                    class="flex h-8 w-8 shrink-0 items-center justify-center
                           rounded-lg border border-amber-400/10
                           bg-amber-400/[0.04]
                           font-mono text-[10px] font-semibold
                           text-amber-300">
                    03
                </div>

                <div>
                    <p
                        class="text-[8px] font-semibold uppercase
                               tracking-[0.15em] text-amber-300/50">
                        Diagnostic Considerations
                    </p>

                    <h3 class="mt-0.5 text-sm font-bold text-white">
                        Differential Diagnosis
                    </h3>
                </div>

            </div>


            <div class="mt-3 border-t border-white/[0.05] pt-3">

                @if ($case->diff_diagnostic)

                    <p class="whitespace-pre-line break-words text-sm leading-6 text-slate-300">
                        {{ $case->diff_diagnostic }}
                    </p>

                @else

                    <p class="text-xs italic text-slate-600">
                        No differential diagnosis documented.
                    </p>

                @endif

            </div>

        </article>


        {{-- Final Diagnosis --}}
        <article
            class="relative overflow-hidden rounded-xl
                   border border-violet-400/10
                   bg-violet-400/[0.03] p-4">

            <div
                class="pointer-events-none absolute -right-10 -top-10
                       h-24 w-24 rounded-full
                       bg-violet-400/[0.05] blur-3xl">
            </div>


            <div class="relative">

                <div class="flex items-center gap-3">

                    <div
                        class="flex h-8 w-8 shrink-0 items-center justify-center
                               rounded-lg border border-violet-400/15
                               bg-violet-400/[0.06]
                               font-mono text-[10px] font-semibold
                               text-violet-300">
                        04
                    </div>

                    <div>
                        <p
                            class="text-[8px] font-semibold uppercase
                                   tracking-[0.15em] text-violet-300/60">
                            Final Interpretation
                        </p>

                        <h3 class="mt-0.5 text-sm font-bold text-white">
                            Diagnosis
                        </h3>
                    </div>

                </div>


                <div class="mt-3 border-t border-white/[0.06] pt-3">

                    @if ($case->diagnosis)

                        <p class="whitespace-pre-line break-words text-sm font-medium leading-6 text-slate-200">
                            {{ $case->diagnosis }}
                        </p>

                    @else

                        <p class="text-xs italic text-slate-600">
                            Final diagnosis has not been documented.
                        </p>

                    @endif

                </div>

            </div>

        </article>


        {{-- Conclusion --}}
        <article
            class="relative overflow-hidden rounded-xl
                   border border-emerald-400/10
                   bg-emerald-400/[0.025] p-4">

            <div
                class="pointer-events-none absolute -right-10 -top-10
                       h-24 w-24 rounded-full
                       bg-emerald-400/[0.05] blur-3xl">
            </div>


            <div class="relative">

                <div class="flex items-center gap-3">

                    <div
                        class="flex h-8 w-8 shrink-0 items-center justify-center
                               rounded-lg border border-emerald-400/15
                               bg-emerald-400/[0.06]
                               font-mono text-[10px] font-semibold
                               text-emerald-300">
                        05
                    </div>

                    <div>
                        <p
                            class="text-[8px] font-semibold uppercase
                                   tracking-[0.15em] text-emerald-300/60">
                            Case Summary
                        </p>

                        <h3 class="mt-0.5 text-sm font-bold text-white">
                            Conclusion
                        </h3>
                    </div>

                </div>


                <div class="mt-3 border-t border-white/[0.06] pt-3">

                    @if ($case->conclusion)

                        <p class="whitespace-pre-line break-words text-sm font-medium leading-6 text-slate-200">
                            {{ $case->conclusion }}
                        </p>

                    @else

                        <p class="text-xs italic text-slate-600">
                            Final conclusion has not been documented.
                        </p>

                    @endif

                </div>

            </div>

        </article>

    </div>

</section>