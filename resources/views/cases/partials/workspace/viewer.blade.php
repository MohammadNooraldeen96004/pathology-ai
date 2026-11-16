 {{-- =================================================
                LEFT — WSI VIEWER
            ================================================== --}}

 <div
     class="min-w-0 overflow-hidden
                       rounded-2xl border border-white/[0.07]
                       bg-black shadow-2xl">

     {{-- Viewer toolbar --}}
     <div
         class="flex min-h-[62px] flex-wrap
                           items-center justify-between gap-4
                           border-b border-white/[0.07]
                           bg-[#050B14] px-5 py-3">

         <div class="min-w-0">

             <div
                 class="flex items-center gap-2
                                   text-[9px] font-semibold uppercase
                                   tracking-[0.18em] text-[#06B6D4]">
                 <span
                     class="h-1.5 w-1.5 rounded-full
                                       bg-[#06B6D4]
                                       shadow-[0_0_10px_rgba(6,182,212,.8)]"></span>

                 Digital Pathology Viewer
             </div>


             <p class="mt-1 max-w-xl truncate
                                   text-xs font-medium text-slate-400"
                 x-text="
                                activeSlide
                                    ? activeSlide.name
                                    : 'No slide selected'
                            ">
             </p>

         </div>


         {{-- Viewer controls --}}
         <div class="flex items-center gap-1.5">

             <button type="button" @click="zoomOut()" class="viewer-control" title="Zoom out">
                 −
             </button>

             <button type="button" @click="zoomIn()" class="viewer-control" title="Zoom in">
                 +
             </button>

             <button type="button" @click="goHome()" class="viewer-control px-3" title="Fit whole slide">
                 Fit
             </button>

             <div class="mx-1 h-5 w-px bg-white/[0.08]"></div>

             <button type="button" @click="toggleFullScreen()" class="viewer-control px-3" title="Full screen">
                 <span class="hidden sm:inline">
                     Full Screen
                 </span>

                 <svg class="h-4 w-4 sm:hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="1.8">
                     <path d="M8 3H3v5" />
                     <path d="M16 3h5v5" />
                     <path d="M8 21H3v-5" />
                     <path d="M16 21h5v-5" />
                 </svg>

             </button>

         </div>

     </div>


     {{-- Actual WSI stage --}}
     <div class="relative h-[72vh] min-h-[620px] max-h-[820px] bg-[#010409]">

         {{-- subtle technical background --}}
         <div
             class="pointer-events-none absolute inset-0
                               bg-[radial-gradient(circle_at_center,rgba(6,182,212,0.025),transparent_50%)]">
         </div>


         <div x-ref="viewer" class="relative z-10 h-full w-full"></div>


         {{-- Loading --}}
         <div x-show="loading" x-cloak
             class="absolute inset-0 z-30
                               flex items-center justify-center
                               bg-[#010409]/95">

             <div class="text-center">

                 <div
                     class="mx-auto flex h-11 w-11
                                       items-center justify-center
                                       rounded-full border
                                       border-[#06B6D4]/15
                                       bg-[#06B6D4]/[0.04]">

                     <svg class="h-5 w-5 animate-spin
                                           text-[#06B6D4]"
                         viewBox="0 0 24 24" fill="none">
                         <circle class="opacity-20" cx="12" cy="12" r="9" stroke="currentColor"
                             stroke-width="2" />

                         <path fill="currentColor" d="M12 3a9 9 0 00-9 9h2.5A6.5 6.5 0 0112 5.5V3z" />
                     </svg>

                 </div>

                 <p class="mt-4 text-xs font-medium
                                       text-slate-400">
                     Rendering whole slide image
                 </p>

                 <p class="mt-1 text-[10px] text-slate-600">
                     Loading high-resolution tiles…
                 </p>

             </div>

         </div>


         {{-- Error --}}
         <div x-show="error" x-cloak
             class="absolute inset-0 z-30
                               flex items-center justify-center
                               bg-[#010409]">

             <div class="max-w-sm px-6 text-center">

                 <div
                     class="mx-auto flex h-10 w-10
                                       items-center justify-center
                                       rounded-full border
                                       border-red-400/15
                                       bg-red-400/[0.05]
                                       text-red-400">
                     !
                 </div>

                 <p class="mt-4 text-sm font-semibold
                                       text-red-300">
                     Unable to open pathology slide
                 </p>

                 <p class="mt-2 text-xs leading-5
                                       text-slate-500" x-text="error">
                 </p>

             </div>

         </div>

     </div>


 </div>
