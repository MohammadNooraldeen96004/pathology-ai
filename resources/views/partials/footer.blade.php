{{-- ============================================================
         FOOTER (ANIMATED CYBER-MINIMALIST)
    ============================================================ --}}
<footer id="about" class="relative border-t border-white/[0.05] bg-[#02050A] pt-20 pb-8 overflow-hidden"
    x-data="{ shown: false }" x-init="let ob = new IntersectionObserver(e => { if (e[0].isIntersecting) shown = true; }, { threshold: 0.1 });
    ob.observe($el);">

    {{-- إضاءة سيبرانية متحركة تفصل الفوتر عن الموقع --}}
    <div class="absolute top-0 left-0 h-px w-full bg-gradient-to-r from-transparent via-[#06B6D4]/50 to-transparent transition-all duration-[2000ms] ease-out"
        :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-full'"></div>

    <div class="relative z-10 mx-auto max-w-7xl px-6 lg:px-8">

        <div class="grid gap-12 md:grid-cols-2 lg:grid-cols-4">

            {{-- Brand (يظهر أولاً) --}}
            <div class="lg:col-span-2 transition-all duration-[1500ms] lusion-ease"
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'">

                <div class="flex items-center gap-3">
                    {{-- استخدام الشعار المدمج --}}
                    <img src="{{ asset('image/compact.png') }}" alt="Pathology AI"
                        class="h-20 w-auto transition-transform duration-500 hover:scale-105">
                </div>

                <p class="mt-6 max-w-md text-sm leading-relaxed text-slate-400">
                    An AI-assisted digital pathology platform designed to support pathology workflows, case review, and
                    clinical decision support through advanced gigapixel analysis.
                </p>

            </div>

            {{-- Platform Links (تأخير 150ms) --}}
            <div class="transition-all duration-[1500ms] lusion-ease"
                :class="shown ? 'opacity-100 translate-y-0 delay-[150ms]' : 'opacity-0 translate-y-12'">
                <h3 class="text-sm font-bold tracking-wider text-white uppercase">
                    Platform
                </h3>
                <ul class="mt-6 space-y-4 text-sm text-slate-400">
                    @foreach ([['#technology', 'Technology'], ['#workflow', 'Workflow'], ['#platform', 'Features']] as [$link, $label])
                        <li class="group">
                            <a href="{{ $link }}"
                                class="flex items-center gap-2 transition-all duration-300 hover:text-[#06B6D4] hover:translate-x-1">
                                <span class="h-px w-0 bg-[#06B6D4] transition-all duration-300 group-hover:w-3"></span>
                                {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Project Links (تأخير 300ms) --}}
            <div class="transition-all duration-[1500ms] lusion-ease"
                :class="shown ? 'opacity-100 translate-y-0 delay-[300ms]' : 'opacity-0 translate-y-12'">
                <h3 class="text-sm font-bold tracking-wider text-white uppercase">
                    Project
                </h3>
                <ul class="mt-6 space-y-4 text-sm text-slate-400">
                    <li class="group">
                        <a href="#about"
                            class="flex items-center gap-2 transition-all duration-300 hover:text-[#8B5CF6] hover:translate-x-1">
                            <span class="h-px w-0 bg-[#8B5CF6] transition-all duration-300 group-hover:w-3"></span>
                            About
                        </a>
                    </li>
                    <li class="group cursor-default">
                        <span
                            class="flex items-center gap-2 transition-all duration-300 hover:text-slate-300 hover:translate-x-1">
                            <span class="h-px w-0 bg-slate-400 transition-all duration-300 group-hover:w-3"></span>
                            AI-assisted analysis
                        </span>
                    </li>
                    <li class="group cursor-default">
                        <span
                            class="flex items-center gap-2 transition-all duration-300 hover:text-slate-300 hover:translate-x-1">
                            <span class="h-px w-0 bg-slate-400 transition-all duration-300 group-hover:w-3"></span>
                            Digital pathology
                        </span>
                    </li>
                </ul>
            </div>

        </div>

        {{-- الشريط السفلي (يظهر بانسيابية من الأسفل - تأخير 500ms) --}}
        <div class="mt-16 flex flex-col items-center justify-between gap-6 border-t border-white/[0.05] pt-8 sm:flex-row transition-all duration-[1500ms] lusion-ease"
            :class="shown ? 'opacity-100 translate-y-0 delay-[500ms]' : 'opacity-0 translate-y-8'">

            <p class="text-xs text-slate-500">
                &copy; {{ date('Y') }} Pathology AI. All rights reserved.
            </p>

            {{-- التنويه الطبي بتفاعل عند مرور الماوس --}}
            <div
                class="group flex items-center gap-2 rounded-full border border-white/5 bg-white/[0.02] px-4 py-2 backdrop-blur-sm transition-all duration-500 hover:border-[#8B5CF6]/30 hover:bg-[#8B5CF6]/5">
                <div
                    class="h-1.5 w-1.5 rounded-full bg-[#8B5CF6] animate-pulse transition-transform duration-300 group-hover:scale-150">
                </div>
                <span
                    class="text-[0.65rem] font-mono tracking-widest text-slate-400 uppercase transition-colors duration-300 group-hover:text-slate-300">
                    AI-assisted system — not a replacement for clinical judgment
                </span>
            </div>

        </div>

    </div>
</footer>
