<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">

            {{-- Case identity --}}
            <div>

                <div
                    class="mb-2 flex flex-wrap items-center gap-2 text-[11px] font-medium uppercase tracking-[0.16em] text-slate-500">

                    <span>Clinical Case</span>

                    <span class="text-slate-700">/</span>

                    <span class="font-mono text-[#06B6D4]">
                        {{ $case->case_number }}
                    </span>

                </div>

                <div class="flex flex-wrap items-center gap-3">

                    <h1 class="app-heading-accent text-3xl font-extrabold tracking-tight sm:text-4xl">
                        Case Workspace
                    </h1>

                    <x-status-badge :status="$case->status" />

                </div>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-400">
                    Review patient information, clinical intake, slide status,
                    diagnostic workflow, and reporting progress.
                </p>

            </div>


            {{-- Actions --}}
            <div class="flex flex-wrap items-center gap-3">

                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-white/10 bg-white/[0.02] px-4 py-2.5 text-sm font-medium text-slate-300 transition hover:border-white/15 hover:bg-white/[0.05] hover:text-white">
                    Dashboard
                </a>

                <a href="{{ route('cases.index', [
                    'search' => request('search'),
                    'status' => request('status'),
                    'page' => request('page'),
                ]) }}"
                    class="inline-flex items-center justify-center rounded-xl border border-white/10 bg-white/[0.02] px-4 py-2.5 text-sm font-medium text-slate-300 transition hover:border-white/15 hover:bg-white/[0.05] hover:text-white">
                    ← Back to Cases
                </a>

                @if ($case->status !== 'completed')
                    <a href="{{ route('cases.edit', [
                        'case' => $case,
                        'search' => request('search'),
                        'status' => request('status'),
                        'page' => request('page'),
                    ]) }}"
                        class="inline-flex items-center justify-center rounded-xl bg-[#06B6D4] px-5 py-2.5 text-sm font-bold text-[#030914] transition hover:brightness-110">
                        Edit Case
                    </a>

                    <form method="POST" action="{{ route('cases.complete', $case) }}">
                        @csrf
                        @method('PATCH')

                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-xl
                   bg-emerald-400 px-5 py-2.5
                   text-sm font-bold text-[#030914]
                   transition hover:brightness-110">
                            Complete Case
                        </button>
                    </form>
                @endif

            </div>

        </div>

    </x-slot>


    <div class="py-10 sm:py-12">

        <div class="mx-auto w-full max-w-[1800px] px-3 sm:px-5 lg:px-6">

            @include('cases.partials.case-summary')

            @include('cases.partials.pathology-workspace')


            {{-- =========================================================
                WORKSPACE GRID
            ========================================================== --}}
            <div class="mt-7 grid grid-cols-1 gap-6 xl:grid-cols-[1fr_360px]">
                

                {{-- LEFT COLUMN --}}
                <div class="space-y-6">

                    @include('cases.partials.clinical-workflow')
                </div>
                {{-- RIGHT COLUMN --}}
                <aside class="space-y-6">

                    @include('cases.partials.slide-management')
                </aside>
                
            </div>

        </div>

    </div>

</x-app-layout>
