   {{-- =================================================
    LEFT — SLIDE NAVIGATION
================================================== --}}

                        <aside
                            class="overflow-hidden rounded-2xl
           border border-white/[0.07]
           bg-[#050B14]">

                            {{-- Heading --}}
                            <div class="border-b border-white/[0.07]
               px-4 py-4">
                                <div
                                    class="text-[9px] font-semibold uppercase
                   tracking-[0.18em] text-[#06B6D4]">
                                    Whole Slide Images
                                </div>

                                <div class="mt-1 flex items-center justify-between">

                                    <h3 class="text-sm font-bold text-white">
                                        Slides
                                    </h3>

                                    <span
                                        class="rounded-md bg-white/[0.04]
                       px-2 py-1 text-[10px]
                       font-semibold text-slate-500">
                                        {{ $case->slides->count() }}
                                    </span>

                                </div>
                            </div>


                            {{-- Slides --}}
                            <div class="max-h-[calc(100vh-230px)]
               space-y-2 overflow-y-auto p-3">

                                <template x-for="(slide, index) in slides" :key="slide.id">

                                    <button type="button" @click="selectSlide(slide.id)"
                                        class="group w-full rounded-xl border
                       p-3 text-left transition duration-200"
                                        :class="activeSlideId === slide.id ?
                                            'border-[#06B6D4]/40 bg-[#06B6D4]/[0.07]' :
                                            'border-white/[0.06] bg-white/[0.02] hover:border-white/[0.13] hover:bg-white/[0.04]'">

                                        <div class="flex items-start gap-3">

                                            {{-- Number --}}
                                            <div class="flex h-8 w-8 shrink-0
                               items-center justify-center
                               rounded-lg border
                               text-[10px] font-bold"
                                                :class="activeSlideId === slide.id ?
                                                    'border-[#06B6D4]/25 bg-[#06B6D4]/10 text-[#67e8f9]' :
                                                    'border-white/[0.07] bg-white/[0.03] text-slate-500'"
                                                x-text="index + 1"></div>


                                            <div class="min-w-0 flex-1">

                                                <p class="truncate text-[11px]
                                   font-semibold"
                                                    :class="activeSlideId === slide.id ?
                                                        'text-[#67e8f9]' :
                                                        'text-slate-300'"
                                                    x-text="slide.name"></p>

                                                <p
                                                    class="mt-1 text-[9px] uppercase
                                   tracking-[0.12em]
                                   text-slate-600">
                                                    TIFF · WSI
                                                </p>

                                            </div>

                                        </div>


                                        {{-- Active indicator --}}
                                        <div x-show="activeSlideId === slide.id"
                                            class="mt-3 flex items-center gap-1.5
                           text-[9px] font-semibold uppercase
                           tracking-[0.12em]
                           text-[#06B6D4]">
                                            <span
                                                class="h-1.5 w-1.5 rounded-full
                               bg-[#06B6D4]"></span>

                                            Viewing
                                        </div>

                                    </button>

                                </template>

                            </div>

                        </aside>
