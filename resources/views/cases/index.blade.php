<x-app-layout>

    <x-slot name="header">

        <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">

            {{-- Title --}}
            <div>

                <div
                    class="mb-2 flex items-center gap-2 text-[11px] font-medium uppercase tracking-[0.17em] text-[#06B6D4]/75">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#06B6D4] shadow-[0_0_10px_rgba(6,182,212,.75)]"></span>
                    Clinical Case Management
                </div>

                <h1 class="app-heading-accent text-3xl font-extrabold tracking-tight sm:text-4xl">
                    Clinical Cases
                </h1>

                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-400">
                    Search, review, and manage pathology cases assigned to your clinical account.
                </p>

            </div>


            {{-- Header Actions --}}
            <div class="flex flex-wrap items-center gap-3">

                <a href="{{ route('cases.archive') }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-white/[0.08] bg-white/[0.025] px-4 py-2.5 text-sm font-medium text-slate-300 transition duration-200 hover:border-white/[0.14] hover:bg-white/[0.05] hover:text-white">

                    <svg class="h-4 w-4 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.7">
                        <path d="M4 7h16M5 7l1 13h12l1-13M9 11h6M8 4h8l1 3H7l1-3z" />
                    </svg>

                    Archived Cases
                </a>


                <a href="{{ route('cases.create') }}"
                    class="group inline-flex items-center gap-2 rounded-xl bg-[#06B6D4] px-5 py-2.5 text-sm font-bold text-[#030914] shadow-[0_0_24px_rgba(6,182,212,.15)] transition duration-300 hover:-translate-y-0.5 hover:shadow-[0_0_32px_rgba(6,182,212,.28)]">

                    <span class="text-lg leading-none transition duration-300 group-hover:rotate-90">
                        +
                    </span>

                    New Case
                </a>

            </div>

        </div>

    </x-slot>


    <div class="py-10 sm:py-12">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">


            {{-- =====================================================
                SEARCH + FILTER
            ====================================================== --}}
            <section class="app-panel relative mb-7 overflow-hidden p-5 sm:p-6">

                <div
                    class="pointer-events-none absolute -right-20 -top-24 h-56 w-56 rounded-full bg-[#06B6D4]/[0.06] blur-[75px]">
                </div>

                <div class="relative">

                    <div class="mb-5 flex items-center justify-between">

                        <div>

                            <div class="text-[10px] font-medium uppercase tracking-[0.16em] text-[#67e8f9]/65">
                                Case Discovery
                            </div>

                            <h2 class="mt-1 text-base font-bold text-white">
                                Search & Filter
                            </h2>

                        </div>


                        @if ($search !== '' || $status)
                            <a href="{{ route('cases.index') }}"
                                class="text-xs font-medium text-slate-500 transition hover:text-white">
                                Clear all filters
                            </a>
                        @endif

                    </div>


                    <form method="GET" action="{{ route('cases.index') }}"
                        class="grid grid-cols-1 gap-4 lg:grid-cols-[1fr_230px_auto] lg:items-end">


                        {{-- Search --}}
                        <div>

                            <label for="search"
                                class="mb-2 block text-[11px] font-medium uppercase tracking-[0.13em] text-slate-500">
                                Search Cases
                            </label>


                            <div class="relative">

                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">

                                    <svg class="h-4 w-4 text-slate-600" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.7">
                                        <circle cx="11" cy="11" r="7" />
                                        <path d="M20 20l-3.5-3.5" />
                                    </svg>

                                </div>


                                <input id="search" type="text" name="search" value="{{ $search }}"
                                    placeholder="Case number, patient name or patient code..."
                                    class="w-full rounded-xl border border-white/[0.08] bg-[#07111D]/80 py-3 pl-11 pr-4 text-sm text-white placeholder:text-slate-600 outline-none transition duration-200 focus:border-[#06B6D4]/50 focus:ring-4 focus:ring-[#06B6D4]/[0.06]">

                            </div>

                        </div>


                        {{-- Status --}}
                        <div>

                            <label for="status"
                                class="mb-2 block text-[11px] font-medium uppercase tracking-[0.13em] text-slate-500">
                                Case Status
                            </label>

                            <select id="status" name="status"
                                class="w-full rounded-xl border border-white/[0.08] bg-[#07111D]/80 px-4 py-3 text-sm text-white outline-none transition duration-200 focus:border-[#06B6D4]/50">

                                <option value="">
                                    All Cases
                                </option>

                                <option value="pending" @selected($status === 'pending')>
                                    Pending
                                </option>

                                <option value="processing" @selected($status === 'processing')>
                                    Processing
                                </option>

                                <option value="completed" @selected($status === 'completed')>
                                    Completed
                                </option>

                            </select>

                        </div>


                        {{-- Apply --}}
                        <button type="submit"
                            class="inline-flex h-[46px] items-center justify-center gap-2 rounded-xl bg-[#06B6D4] px-5 text-sm font-bold text-[#030914] shadow-[0_0_20px_rgba(6,182,212,.12)] transition duration-200 hover:brightness-110">
                            Apply Filters
                        </button>

                    </form>

                </div>

            </section>



            {{-- =====================================================
                CASE TABLE
            ====================================================== --}}
            <section class="app-panel overflow-hidden">


                {{-- Table Header --}}
                <div
                    class="flex flex-col gap-4 border-b border-white/[0.06] px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <div class="text-[10px] font-medium uppercase tracking-[0.15em] text-slate-600">
                            Case Registry
                        </div>

                        <h2 class="mt-1 text-lg font-bold text-white">
                            All Clinical Cases
                        </h2>

                        <p class="mt-1 text-xs text-slate-500">

                            <span class="font-semibold text-slate-300">
                                {{ $cases->total() }}
                            </span>

                            @if ($search !== '' || $status)
                                matching
                            @endif

                            {{ $cases->total() === 1 ? 'clinical case' : 'clinical cases' }}

                        </p>

                    </div>


                    @if ($search !== '' || $status)

                        <div class="flex flex-wrap gap-2">

                            @if ($search !== '')
                                <span
                                    class="rounded-lg border border-[#06B6D4]/15 bg-[#06B6D4]/[0.05] px-3 py-1.5 text-xs text-[#67e8f9]">
                                    Search: {{ $search }}
                                </span>
                            @endif

                            @if ($status)
                                <span
                                    class="rounded-lg border border-white/[0.07] bg-white/[0.03] px-3 py-1.5 text-xs text-slate-300">
                                    {{ ucfirst($status) }}
                                </span>
                            @endif

                        </div>

                    @endif

                </div>



                {{-- Table --}}
                <div class="overflow-x-auto">

                    <table class="w-full text-left text-sm text-slate-400">


                        <thead
                            class="border-b border-white/[0.05] bg-white/[0.015] text-[10px] uppercase tracking-[0.13em] text-slate-500">

                            <tr>
                                <th class="px-6 py-4 font-medium">
                                    Case
                                </th>

                                <th class="px-6 py-4 font-medium">
                                    Patient
                                </th>

                                <th class="px-6 py-4 font-medium">
                                    Specialization
                                </th>

                                <th class="px-6 py-4 font-medium">
                                    Slides
                                </th>

                                <th class="px-6 py-4 font-medium">
                                    Status
                                </th>

                                <th class="px-6 py-4 font-medium">
                                    Created
                                </th>

                                <th class="px-6 py-4 text-right font-medium">
                                    Actions
                                </th>
                            </tr>

                        </thead>


                        <tbody class="divide-y divide-white/[0.05]">

                            @forelse ($cases as $case)
                                <tr class="group transition duration-200 hover:bg-white/[0.025]">


                                    {{-- Case --}}
                                    <td class="px-6 py-5">

                                        <a href="{{ route('cases.show', [
                                            'case' => $case,
                                            'search' => $search ?: null,
                                            'status' => $status ?: null,
                                            'page' => request('page'),
                                        ]) }}"
                                            class="group/case inline-flex flex-col">

                                            <span
                                                class="font-mono text-sm font-semibold text-[#06B6D4] transition group-hover/case:text-[#67e8f9]">
                                                {{ $case->case_number }}
                                            </span>

                                            <span class="mt-1 text-[10px] text-slate-600">
                                                Case #{{ $case->id }}
                                            </span>

                                        </a>

                                    </td>



                                    {{-- Patient --}}
                                    <td class="px-6 py-5">

                                        @if ($case->patient)
                                            <div class="flex items-center gap-3">

                                                <div
                                                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-[#06B6D4]/15 bg-[#06B6D4]/[0.06] text-xs font-bold text-[#06B6D4]">
                                                    {{ strtoupper(substr($case->patient->name ?? 'P', 0, 1)) }}
                                                </div>


                                                <div>

                                                    <div class="font-semibold text-white">
                                                        {{ $case->patient->name ?? 'Unnamed Patient' }}
                                                    </div>

                                                    <div class="mt-1 text-xs text-slate-500">

                                                        {{ $case->patient->patient_code ?? '-' }}

                                                        <span class="mx-1 text-slate-700">•</span>

                                                        {{ $case->patient->gender ?? '-' }}

                                                        <span class="mx-1 text-slate-700">•</span>

                                                        {{ $case->patient->age ?? '-' }} yrs

                                                    </div>

                                                </div>

                                            </div>
                                        @else
                                            <span
                                                class="rounded-lg border border-red-400/10 bg-red-400/[0.04] px-2.5 py-1 text-xs text-red-300">
                                                Patient missing
                                            </span>
                                        @endif

                                    </td>



                                    {{-- Specialization --}}
                                    <td class="px-6 py-5">

                                        <span class="text-sm text-slate-300">
                                            {{ $case->specialization ?: 'Not specified' }}
                                        </span>

                                    </td>



                                    {{-- Slides --}}
                                    <td class="px-6 py-5">

                                        <div
                                            class="inline-flex items-center gap-2 rounded-lg border border-white/[0.07] bg-white/[0.025] px-2.5 py-1.5">

                                            <svg class="h-3.5 w-3.5 text-slate-500" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="1.7">
                                                <rect x="5" y="4" width="14" height="16" rx="2" />
                                                <path d="M8 8h8M8 12h8" />
                                            </svg>

                                            <span class="text-xs font-medium text-slate-300">
                                                {{ $case->slides_count }}
                                                {{ $case->slides_count === 1 ? 'slide' : 'slides' }}
                                            </span>

                                        </div>

                                    </td>



                                    {{-- Status --}}
                                    <td class="px-6 py-5">
                                        <x-status-badge :status="$case->status" />
                                    </td>



                                    {{-- Created --}}
                                    <td class="px-6 py-5 whitespace-nowrap">

                                        <div class="text-sm text-slate-300">
                                            {{ $case->created_at->format('M d, Y') }}
                                        </div>

                                        <div class="mt-1 text-[10px] text-slate-600">
                                            {{ $case->created_at->format('H:i') }}
                                        </div>

                                    </td>



                                    {{-- Actions --}}
                                    <td class="px-6 py-5">

                                        <div class="flex items-center justify-end gap-2">


                                            {{-- Open --}}
                                            <a href="{{ route('cases.show', [
                                                'case' => $case,
                                                'search' => $search ?: null,
                                                'status' => $status ?: null,
                                                'page' => request('page'),
                                            ]) }}"
                                                class="inline-flex items-center rounded-lg border border-[#06B6D4]/15 bg-[#06B6D4]/[0.05] px-3 py-2 text-xs font-semibold text-[#06B6D4] transition hover:border-[#06B6D4]/30 hover:bg-[#06B6D4]/[0.09]">

                                                Open
                                            </a>


                                            {{-- Edit --}}
                                            <a href="{{ route('cases.edit', [
                                                'case' => $case,
                                                'search' => $search ?: null,
                                                'status' => $status ?: null,
                                                'page' => request('page'),
                                            ]) }}"
                                                class="inline-flex items-center rounded-lg border border-violet-400/15 bg-violet-400/[0.04] px-3 py-2 text-xs font-semibold text-violet-300 transition hover:border-violet-400/30 hover:bg-violet-400/[0.08]">

                                                Edit
                                            </a>


                                            {{-- Archive --}}
                                            <form method="POST" action="{{ route('cases.destroy', $case) }}"
                                                onsubmit="return confirm('Archive this clinical case?');">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" title="Archive case"
                                                    class="inline-flex h-[34px] w-[34px] items-center justify-center rounded-lg border border-red-400/10 bg-red-400/[0.025] text-red-400 transition hover:border-red-400/25 hover:bg-red-400/[0.07] hover:text-red-300">

                                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="1.7">
                                                        <path d="M4 7h16M6 7l1 13h10l1-13M9 11h6M9 4h6l1 3H8l1-3z" />
                                                    </svg>

                                                </button>

                                            </form>

                                        </div>

                                    </td>


                                </tr>


                            @empty

                                <tr>

                                    <td colspan="7" class="px-6 py-20 text-center">


                                        @if ($search !== '' || $status)
                                            <div
                                                class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl border border-white/[0.07] bg-white/[0.025]">

                                                <svg class="h-5 w-5 text-slate-500" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="1.7">
                                                    <circle cx="11" cy="11" r="7" />
                                                    <path d="M20 20l-3.5-3.5" />
                                                </svg>

                                            </div>

                                            <div class="mt-4 text-base font-semibold text-slate-300">
                                                No matching cases found
                                            </div>

                                            <p class="mt-2 text-sm text-slate-500">
                                                Try adjusting your search query or case status.
                                            </p>

                                            <a href="{{ route('cases.index') }}"
                                                class="mt-5 inline-flex rounded-xl border border-white/10 px-5 py-2.5 text-sm font-medium text-slate-300 transition hover:bg-white/[0.05] hover:text-white">
                                                Clear Filters
                                            </a>
                                        @else
                                            <div
                                                class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl border border-[#06B6D4]/15 bg-[#06B6D4]/[0.05] text-xl font-light text-[#06B6D4]">
                                                +
                                            </div>

                                            <div class="mt-4 text-base font-semibold text-slate-300">
                                                No clinical cases yet
                                            </div>

                                            <p class="mt-2 text-sm text-slate-500">
                                                Create your first clinical case to begin the pathology workflow.
                                            </p>

                                            <a href="{{ route('cases.create') }}"
                                                class="mt-5 inline-flex rounded-xl bg-[#06B6D4] px-5 py-2.5 text-sm font-bold text-[#030914]">
                                                Create First Case
                                            </a>
                                        @endif


                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>



                {{-- Pagination --}}
                @if ($cases->hasPages())
                    <div class="border-t border-white/[0.06] bg-white/[0.01] px-6 py-4">

                        {{ $cases->links() }}

                    </div>
                @endif


            </section>

        </div>

    </div>

</x-app-layout>
