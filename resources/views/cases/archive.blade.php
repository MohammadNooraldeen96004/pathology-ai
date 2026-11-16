<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="text-2xl font-bold tracking-tight text-white">
                    Archived Cases
                </h2>

                <p class="mt-1 text-sm text-slate-400">
                    Review and restore archived clinical cases.
                </p>
            </div>

            <a href="{{ route('cases.index') }}"
                class="inline-flex items-center text-sm font-medium text-[#06B6D4] transition hover:text-cyan-300">
                ← Back to Cases
            </a>

        </div>
    </x-slot>


    <div class="py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if (session('success'))
                <div
                    class="mb-6 rounded-xl border border-emerald-400/20 bg-emerald-400/[0.06] px-4 py-3 text-sm text-emerald-300">
                    {{ session('success') }}
                </div>
            @endif


            <div class="overflow-hidden rounded-2xl border border-white/5 bg-[#050B14] shadow-2xl">

                {{-- Header --}}
                <div class="flex items-center justify-between border-b border-white/5 px-6 py-5">

                    <div>
                        <h3 class="font-bold text-white">
                            Archived Clinical Cases
                        </h3>

                        <p class="mt-1 text-xs text-slate-500">
                            {{ $cases->total() }}
                            {{ $cases->total() === 1 ? 'archived case' : 'archived cases' }}
                        </p>
                    </div>

                </div>


                <div class="overflow-x-auto">

                    <table class="w-full text-left text-sm text-slate-400">

                        <thead class="border-b border-white/5 bg-white/[0.02] text-xs uppercase text-slate-300">

                            <tr>
                                <th class="px-6 py-4 font-medium tracking-wider">
                                    Case
                                </th>

                                <th class="px-6 py-4 font-medium tracking-wider">
                                    Patient
                                </th>

                                <th class="px-6 py-4 font-medium tracking-wider">
                                    Specialization
                                </th>

                                <th class="px-6 py-4 font-medium tracking-wider">
                                    Slides
                                </th>

                                <th class="px-6 py-4 font-medium tracking-wider">
                                    Archived
                                </th>

                                <th class="px-6 py-4 text-right font-medium tracking-wider">
                                    Action
                                </th>
                            </tr>

                        </thead>


                        <tbody class="divide-y divide-white/5">

                            @forelse ($cases as $case)
                                <tr class="transition hover:bg-white/[0.02]">

                                    {{-- Case --}}
                                    <td class="px-6 py-5">

                                        <div class="font-mono font-medium text-[#06B6D4]">
                                            {{ $case->case_number }}
                                        </div>

                                        <div class="mt-1 text-xs text-slate-600">
                                            ID #{{ $case->id }}
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


                                    {{-- Specialization --}}
                                    <td class="px-6 py-5">
                                        {{ $case->specialization ?: 'Not specified' }}
                                    </td>


                                    {{-- Slides --}}
                                    <td class="px-6 py-5">

                                        <span
                                            class="inline-flex items-center rounded-lg border border-white/10 bg-white/5 px-2.5 py-1 text-xs text-slate-300">
                                            {{ $case->expected_slides }} slides
                                        </span>

                                    </td>


                                    {{-- Archived date --}}
                                    <td class="px-6 py-5">

                                        <div class="text-slate-300">
                                            {{ $case->deleted_at?->format('M d, Y') }}
                                        </div>

                                        <div class="mt-1 text-xs text-slate-600">
                                            {{ $case->deleted_at?->format('H:i') }}
                                        </div>

                                    </td>


                                    {{-- Restore --}}
                                    <td class="px-6 py-5 text-right">

                                        <form method="POST" action="{{ route('cases.restore', $case->id) }}">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                class="inline-flex items-center rounded-lg border border-[#06B6D4]/20 bg-[#06B6D4]/5 px-3 py-2 text-xs font-semibold text-[#06B6D4] transition hover:border-[#06B6D4]/40 hover:bg-[#06B6D4]/10">
                                                Restore Case
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6" class="px-6 py-16 text-center">

                                        <div class="text-base font-medium text-slate-300">
                                            No archived cases.
                                        </div>

                                        <p class="mt-2 text-sm text-slate-500">
                                            Archived clinical cases will appear here.
                                        </p>

                                        <a href="{{ route('cases.index') }}"
                                            class="mt-5 inline-flex rounded-xl border border-white/10 px-5 py-2.5 text-sm font-medium text-slate-300 transition hover:bg-white/5 hover:text-white">
                                            Back to Cases
                                        </a>

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- Pagination --}}
                @if ($cases->hasPages())
                    <div class="border-t border-white/5 px-6 py-4">
                        {{ $cases->links() }}
                    </div>
                @endif

            </div>

        </div>
    </div>

</x-app-layout>
