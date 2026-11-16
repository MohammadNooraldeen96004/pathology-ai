{{-- =========================================================
    SLIDE MANAGEMENT
========================================================== --}}

@php
    $uploadedSlides = $case->slides->count();
    $expectedSlides = max(1, (int) $case->expected_slides);

    $slideProgress = min(100, (int) round(($uploadedSlides / $expectedSlides) * 100));
@endphp


<section class="app-panel app-card-hover relative overflow-hidden">

    {{-- Background accent --}}
    <div
        class="pointer-events-none absolute -right-20 -top-20
               h-52 w-52 rounded-full
               bg-[#06B6D4]/[0.06]
               blur-[80px]">
    </div>


    <div class="relative">

        {{-- =====================================================
            HEADER
        ====================================================== --}}
        <div class="border-b border-white/[0.06] px-5 py-5">

            <div class="flex items-start justify-between gap-4">

                <div>

                    <p
                        class="text-[9px] font-semibold uppercase
                               tracking-[0.18em] text-[#67e8f9]/60">
                        Digital Pathology
                    </p>

                    <h2 class="mt-1.5 text-lg font-bold tracking-tight text-white">
                        Slide Management
                    </h2>

                    <p class="mt-1 text-[11px] leading-5 text-slate-500">
                        Manage whole slide images associated with this case.
                    </p>

                </div>


                @if ($case->status === 'completed')
                    <span
                        class="shrink-0 rounded-full
                               border border-emerald-400/15
                               bg-emerald-400/[0.05]
                               px-2.5 py-1
                               text-[9px] font-semibold uppercase
                               tracking-[0.12em] text-emerald-400">
                        Read Only
                    </span>
                @endif

            </div>

        </div>


        {{-- =====================================================
            SLIDE PROGRESS
        ====================================================== --}}
        <div class="px-5 pt-5">

            <div class="rounded-2xl border border-white/[0.06]
                       bg-[#07111D]/55 p-4">

                <div class="flex items-end justify-between gap-4">

                    <div>

                        <p
                            class="text-[9px] font-semibold uppercase
                                   tracking-[0.15em] text-slate-600">
                            Slide Progress
                        </p>

                        <p class="mt-1.5 text-sm font-semibold text-slate-200">
                            {{ $uploadedSlides }}
                            <span class="font-normal text-slate-600">
                                of {{ $expectedSlides }}
                            </span>
                        </p>

                    </div>


                    <div class="text-right">

                        <p class="font-mono text-lg font-bold text-white">
                            {{ $slideProgress }}%
                        </p>

                    </div>

                </div>


                {{-- Progress bar --}}
                <div class="mt-4 h-1.5 overflow-hidden
                           rounded-full bg-white/[0.05]">

                    <div class="h-full rounded-full bg-[#06B6D4]
                               transition-all duration-500"
                        style="width: {{ $slideProgress }}%">
                    </div>

                </div>


                {{-- State --}}
                <div class="mt-4">

                    @if ($uploadedSlides === 0)
                        <span
                            class="inline-flex items-center gap-2
                                   rounded-full border border-white/[0.07]
                                   bg-white/[0.03]
                                   px-2.5 py-1
                                   text-[9px] font-semibold uppercase
                                   tracking-[0.12em] text-slate-500">

                            <span class="h-1.5 w-1.5 rounded-full
                                       bg-slate-600">
                            </span>

                            Awaiting Slides

                        </span>
                    @elseif ($uploadedSlides < $expectedSlides)
                        <span
                            class="inline-flex items-center gap-2
                                   rounded-full border border-amber-400/15
                                   bg-amber-400/[0.05]
                                   px-2.5 py-1
                                   text-[9px] font-semibold uppercase
                                   tracking-[0.12em] text-amber-300">

                            <span class="h-1.5 w-1.5 rounded-full
                                       bg-amber-300">
                            </span>

                            Partial Slide Set

                        </span>
                    @else
                        <span
                            class="inline-flex items-center gap-2
                                   rounded-full border border-emerald-400/15
                                   bg-emerald-400/[0.05]
                                   px-2.5 py-1
                                   text-[9px] font-semibold uppercase
                                   tracking-[0.12em] text-emerald-400">

                            <span
                                class="h-1.5 w-1.5 rounded-full
                                       bg-emerald-400">
                            </span>

                            Slide Set Ready

                        </span>
                    @endif

                </div>

            </div>

        </div>


        {{-- =====================================================
            UPLOAD
        ====================================================== --}}
        @if ($case->status !== 'completed')
            <div class="px-5 pt-5">

                <div class="mb-3">

                    <p
                        class="text-[9px] font-semibold uppercase
                               tracking-[0.15em] text-slate-600">
                        Add Slide
                    </p>

                    <h3 class="mt-1 text-sm font-semibold text-white">
                        Upload Whole Slide Image
                    </h3>

                </div>


                <form method="POST" action="{{ route('cases.slides.store', $case) }}" enctype="multipart/form-data"
                    x-data="slideUpload" @submit="submitting = true">

                    @csrf


                    {{-- Drop / select area --}}
                    <label for="slide"
                        class="group relative flex cursor-pointer
                               flex-col items-center justify-center
                               overflow-hidden rounded-2xl
                               border border-dashed border-white/[0.10]
                               bg-white/[0.015]
                               px-5 py-7 text-center
                               transition duration-300
                               hover:border-[#06B6D4]/30
                               hover:bg-[#06B6D4]/[0.025]">


                        <div
                            class="flex h-11 w-11 items-center justify-center
                                   rounded-xl border border-[#06B6D4]/15
                                   bg-[#06B6D4]/[0.06]
                                   text-[#06B6D4]
                                   transition duration-200
                                   group-hover:-translate-y-0.5">

                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.7">

                                <path d="M12 16V4" />
                                <path d="M7 9l5-5 5 5" />
                                <path d="M5 14v5h14v-5" />

                            </svg>

                        </div>


                        <p class="mt-3 text-xs font-semibold text-slate-300">
                            Select pathology slide
                        </p>

                        <p class="mt-1 text-[10px] text-slate-600">
                            TIF / TIFF · Maximum 1 GB
                        </p>


                        {{-- Selected file --}}
                        <div x-show="fileName" x-cloak x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="mt-4 w-full rounded-xl
                                   border border-[#06B6D4]/15
                                   bg-[#06B6D4]/[0.045]
                                   px-3 py-3 text-left">

                            <div class="truncate text-[11px]
                                       font-semibold text-[#67e8f9]"
                                x-text="fileName">
                            </div>

                            <div class="mt-1 text-[9px] text-slate-500" x-text="fileSize">
                            </div>

                        </div>


                        <input id="slide" name="slide" type="file" accept=".tif,.tiff,image/tiff"
                            class="sr-only" @change="selectFile($event)">

                    </label>


                    {{-- Validation --}}
                    @error('slide')
                        <div
                            class="mt-3 rounded-xl
                                   border border-red-400/15
                                   bg-red-400/[0.05]
                                   px-4 py-3
                                   text-xs text-red-300">

                            {{ $message }}

                        </div>
                    @enderror


                    {{-- Upload --}}
                    <button type="submit" :disabled="submitting || !fileName"
                        class="mt-3 inline-flex w-full
                               items-center justify-center gap-2
                               rounded-xl bg-[#06B6D4]
                               px-5 py-3
                               text-xs font-bold text-[#030914]
                               transition duration-200
                               hover:brightness-110
                               disabled:cursor-not-allowed
                               disabled:opacity-40">

                        <span x-show="!submitting">
                            Upload Slide
                        </span>


                        <span x-show="submitting" x-cloak class="inline-flex items-center gap-2">

                            <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">

                                <circle class="opacity-25" cx="12" cy="12" r="9" stroke="currentColor"
                                    stroke-width="3">
                                </circle>

                                <path class="opacity-75" fill="currentColor" d="M12 3a9 9 0 00-9 9h3a6 6 0 016-6V3z">
                                </path>

                            </svg>

                            Uploading TIFF...

                        </span>

                    </button>

                </form>

            </div>
        @endif


        {{-- =====================================================
            UPLOADED SLIDES
        ====================================================== --}}
        <div class="mt-5 border-t border-white/[0.06] px-5 py-5">

            <div class="flex items-center justify-between gap-4">

                <div>

                    <p
                        class="text-[9px] font-semibold uppercase
                               tracking-[0.15em] text-slate-600">
                        Case Files
                    </p>

                    <h3 class="mt-1 text-sm font-semibold text-white">
                        Uploaded Slides
                    </h3>

                </div>


                <span
                    class="rounded-full border border-white/[0.07]
                           bg-white/[0.03]
                           px-2.5 py-1
                           font-mono text-[9px] text-slate-500">

                    {{ $uploadedSlides }}

                </span>

            </div>


            @if ($case->slides->isNotEmpty())

                <div class="mt-4 space-y-2">

                    @foreach ($case->slides as $slide)
                        <article
                            class="group rounded-xl
                                   border border-white/[0.06]
                                   bg-white/[0.018]
                                   p-3.5
                                   transition duration-200
                                   hover:border-white/[0.10]
                                   hover:bg-white/[0.03]">

                            {{-- Slide identity --}}
                            <div class="flex items-start gap-3">

                                <div
                                    class="flex h-9 w-9 shrink-0
                                           items-center justify-center
                                           rounded-xl
                                           border border-[#06B6D4]/15
                                           bg-[#06B6D4]/[0.05]">

                                    <svg class="h-4 w-4 text-[#06B6D4]" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.7">

                                        <path d="M6 3h9l3 3v15H6z" />
                                        <path d="M15 3v4h4" />

                                    </svg>

                                </div>


                                <div class="min-w-0 flex-1">

                                    <p class="truncate text-[11px]
                                               font-semibold text-slate-300"
                                        title="{{ $slide->file_name }}">

                                        {{ $slide->file_name }}

                                    </p>

                                    <div class="mt-1.5 flex items-center gap-2">

                                        <span
                                            class="inline-flex items-center gap-1.5
                                                   text-[9px] text-emerald-400">

                                            <span
                                                class="h-1.5 w-1.5
                                                       rounded-full
                                                       bg-emerald-400">
                                            </span>

                                            Stored

                                        </span>

                                        <span class="text-[9px] text-slate-700">
                                            TIFF
                                        </span>

                                    </div>

                                </div>

                            </div>


                            {{-- Actions --}}
                            <div
                                class="mt-3 flex items-center justify-end gap-2
                                       border-t border-white/[0.05] pt-3">

                                {{-- Download --}}
                                <a href="{{ route('cases.slides.download', [$case, $slide]) }}"
                                    class="inline-flex items-center gap-2
                                           rounded-lg border border-white/[0.07]
                                           bg-white/[0.025]
                                           px-3 py-2
                                           text-[10px] font-medium
                                           text-slate-400
                                           transition duration-200
                                           hover:border-[#06B6D4]/25
                                           hover:bg-[#06B6D4]/[0.05]
                                           hover:text-[#67e8f9]"
                                    title="Download original TIFF">

                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="1.7">

                                        <path d="M12 4v11" />
                                        <path d="M8 11l4 4 4-4" />
                                        <path d="M5 20h14" />

                                    </svg>

                                    Download

                                </a>


                                {{-- Delete --}}
                                @if ($case->status !== 'completed')
                                    <form method="POST"
                                        action="{{ route('cases.slides.destroy', [$case, $slide]) }}"
                                        @submit.prevent="
        requestConfirmation(
            $event,
            'Delete this pathology slide? This action cannot be undone.'
        )
    ">
                                        @csrf
                                        @method('DELETE')


                                        <button type="submit"
                                            class="inline-flex items-center gap-2
                                                   rounded-lg
                                                   border border-red-400/10
                                                   bg-red-400/[0.035]
                                                   px-3 py-2
                                                   text-[10px] font-medium
                                                   text-red-400/70
                                                   transition duration-200
                                                   hover:border-red-400/25
                                                   hover:bg-red-400/[0.07]
                                                   hover:text-red-300">

                                            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="1.7">

                                                <path d="M4 7h16" />
                                                <path d="M9 7V4h6v3" />
                                                <path d="M7 7l1 13h8l1-13" />
                                                <path d="M10 11v5" />
                                                <path d="M14 11v5" />

                                            </svg>

                                            Delete

                                        </button>

                                    </form>
                                @endif

                            </div>

                        </article>
                    @endforeach

                </div>
            @else
                <div
                    class="mt-4 rounded-xl
                           border border-dashed border-white/[0.07]
                           bg-white/[0.01]
                           px-5 py-7 text-center">

                    <div
                        class="mx-auto flex h-10 w-10
                               items-center justify-center
                               rounded-xl border border-white/[0.06]
                               bg-white/[0.02]
                               text-slate-600">

                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.7">

                            <path d="M6 3h9l3 3v15H6z" />
                            <path d="M15 3v4h4" />

                        </svg>

                    </div>


                    <p class="mt-3 text-xs font-medium text-slate-400">
                        No pathology slides uploaded
                    </p>

                    <p class="mt-1 text-[10px] leading-5 text-slate-600">
                        Upload the first TIFF whole slide image to begin.
                    </p>

                </div>

            @endif

        </div>

    </div>

</section>
