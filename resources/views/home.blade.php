@extends('layouts.app')

@section('title', 'DEQQA — AI-Assisted Digital Pathology')

@section('content')

    {{-- ============================================================
         GLOBAL STYLES & ANIMATIONS (CONSOLIDATED)
    ============================================================ --}}
    <style>
        /* Global Cinematic Scroll Effect */
        .cinematic-wrapper {
            opacity: 0;
            transform: translateY(100px) scale(0.92);
            filter: blur(20px);
            transition: opacity 1.2s cubic-bezier(0.16, 1, 0.3, 1),
                transform 1.2s cubic-bezier(0.16, 1, 0.3, 1),
                filter 1.2s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform, filter;
        }

        .cinematic-wrapper.is-in-view {
            opacity: 1;
            transform: translateY(0) scale(1);
            filter: blur(0);
        }

        /* Lusion Smooth Easing */
        .lusion-ease {
            transition-timing-function: cubic-bezier(0.2, 1.5, 0.9, 1.6) !important;
        }

        /* Hero 3D Float & Scan Animations */
        @keyframes float-3d {

            0%,
            100% {
                transform: perspective(1200px) rotateY(-12deg) rotateX(5deg) translateY(0px);
            }

            50% {
                transform: perspective(1200px) rotateY(-12deg) rotateX(5deg) translateY(-15px);
            }
        }

        @keyframes scan-laser {
            0% {
                top: -20%;
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            80% {
                opacity: 1;
            }

            100% {
                top: 100%;
                opacity: 0;
            }
        }

        .animate-float-3d {
            animation: float-3d 8s ease-in-out infinite;
        }

        .animate-scan {
            animation: scan-laser 4s linear infinite;
        }

        /* Interactive Spotlight effect for cards */
        .spotlight-card {
            position: relative;
            overflow: hidden;
        }

        .spotlight-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(800px circle at var(--mouse-x) var(--mouse-y), rgba(6, 182, 212, 0.15), transparent 40%);
            z-index: 0;
            transition: opacity 0.5s ease;
            opacity: 0;
            pointer-events: none;
        }

        .spotlight-card:hover::before {
            opacity: 1;
        }
    </style>

    {{-- ============================================================
         GLOBAL SCROLL OBSERVER SCRIPT
    ============================================================ --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // استثناء الـ #hero لأنه يمتلك أنيميشن دخول فوري خاص به
            const sections = document.querySelectorAll('section:not(#hero), footer');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-in-view');
                    } else {
                        entry.target.classList.remove('is-in-view');
                    }
                });
            }, {
                root: null,
                threshold: 0.05,
                rootMargin: "0px 0px -50px 0px"
            });

            sections.forEach(sec => {
                sec.classList.add('cinematic-wrapper');
                observer.observe(sec);
            });
        });
    </script>

    {{-- ============================================================
         SECTION 01: HERO
    ============================================================ --}}
    <section id="hero" x-data="{ mounted: false }" x-init="setTimeout(() => mounted = true, 100)"
        class="relative flex min-h-[90vh] w-full items-center justify-center overflow-hidden bg-[#030914] pt-28 pb-20">

        <div
            class="absolute inset-0 z-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNNTQuNjI3IDU0LjYyN3YtLjAwMW0wIDBoLjAwMXYtLjAwMW0wIDB6IiBzdHJva2U9IiMxMjNBNzMiIHN0cm9rZS1vcGFjaXR5PSIwLjE1IiBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiLz48L3N2Zz4=')] [mask-image:radial-gradient(ellipse_60%_60%_at_50%_50%,#000_20%,transparent_100%)]">
        </div>

        <div
            class="relative z-10 mx-auto grid w-full max-w-[85rem] grid-cols-1 items-center gap-12 px-6 lg:grid-cols-12 lg:gap-8 lg:px-8">

            <div class="flex flex-col items-start lg:col-span-5"
                :class="mounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                class="transition-all duration-1000 ease-out">

                <div
                    class="mb-8 inline-flex items-center gap-3 rounded-full border border-white/10 bg-gradient-to-r from-white/10 to-transparent px-5 py-2 backdrop-blur-xl shadow-[inset_0_1px_0_rgba(255,255,255,0.2)]">
                    <svg class="h-4 w-4 text-[#06B6D4]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <span class="text-[0.7rem] font-extrabold uppercase tracking-[0.2em] text-slate-200">MIL Framework
                        Integrated</span>
                </div>

                <h1 class="text-5xl font-extrabold leading-[1.05] tracking-tight text-white sm:text-6xl lg:text-[4.5rem]">
                    Uncovering <br />
                    insights in <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-[#8B5CF6] to-[#06B6D4]">gigapixels.</span>
                </h1>

                <p class="mt-8 max-w-lg text-lg leading-relaxed text-slate-400">
                    Engineered on a Multiple Instance Learning (MIL) framework, Deqqa analyzes massive gastrointestinal
                    biopsies to pinpoint malignant regions, empowering pathologists with precise, AI-assisted decision
                    support.
                </p>

                <div class="mt-10 flex flex-wrap items-center gap-5">
                    <a href="#platform"
                        class="group relative overflow-hidden rounded-full bg-[#06B6D4] px-8 py-3.5 text-sm font-bold text-[#030914] shadow-[0_0_20px_rgba(6,182,212,0.3)] transition-all duration-300 hover:shadow-[0_0_30px_rgba(6,182,212,0.6)] hover:-translate-y-0.5">
                        <span class="absolute inset-0 flex items-center justify-center">
                            <span
                                class="h-0 w-0 rounded-full bg-white transition-all duration-500 ease-out group-hover:h-64 group-hover:w-64"></span>
                        </span>
                        <span class="relative z-10 flex items-center gap-2.5">
                            Explore Platform
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </span>
                    </a>

                    <a href="#workflow"
                        class="group flex items-center gap-2 text-sm font-bold text-slate-300 transition-colors duration-300 hover:text-white">
                        See how it works
                        <span class="transition-transform duration-300 group-hover:translate-x-1">&rarr;</span>
                    </a>
                </div>
            </div>

            <div class="relative mt-12 w-full lg:col-span-7 lg:mt-0" :class="mounted ? 'opacity-100' : 'opacity-0'"
                class="transition-opacity duration-[1500ms] delay-300 ease-out">

                <div class="animate-float-3d mx-auto w-full max-w-2xl relative">
                    <div
                        class="absolute -inset-1 rounded-2xl bg-gradient-to-tr from-[#06B6D4] to-[#8B5CF6] opacity-20 blur-2xl">
                    </div>

                    <div
                        class="relative overflow-hidden rounded-2xl border border-white/20 bg-[#050B14] shadow-[0_30px_60px_rgba(0,0,0,0.7)]">
                        <div
                            class="relative z-20 flex items-center border-b border-white/10 bg-[#050B14]/80 px-4 py-3 backdrop-blur-md">
                            <div class="flex gap-1.5">
                                <div class="h-2.5 w-2.5 rounded-full bg-slate-600"></div>
                                <div class="h-2.5 w-2.5 rounded-full bg-slate-600"></div>
                                <div class="h-2.5 w-2.5 rounded-full bg-slate-600"></div>
                            </div>
                            <div class="ml-4 flex-1">
                                <span
                                    class="text-[0.6rem] font-mono tracking-widest text-slate-400">ANALYSIS_ENVIRONMENT_GI_04</span>
                            </div>
                        </div>

                        <div x-data="{ panX: 0, panY: 0 }"
                            @mousemove="panX = ($event.clientX / window.innerWidth - 0.5) * 60; panY = ($event.clientY / window.innerHeight - 0.5) * 60"
                            @mouseleave="panX = 0; panY = 0"
                            class="relative aspect-[16/10] w-full bg-[#030914] overflow-hidden cursor-crosshair">

                            <img src="{{ asset('image/ai_pathology_analysis.webp') }}" alt="AI Pathology Analysis"
                                :style="`transform: scale(1.15) translate(${panX}px, ${panY}px)`"
                                class="absolute inset-0 h-full w-full object-cover opacity-80 mix-blend-screen transition-transform duration-700 ease-out will-change-transform">

                            <div
                                class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,transparent_20%,#050B14_100%)] opacity-60 pointer-events-none">
                            </div>

                            <div class="absolute inset-x-0 w-full animate-scan z-10 pointer-events-none">
                                <div class="h-32 w-full bg-gradient-to-b from-transparent via-[#06B6D4]/15 to-transparent">
                                </div>
                                <div class="h-[2px] w-full bg-[#06B6D4] shadow-[0_0_20px_#06B6D4]"></div>
                            </div>

                            <div
                                class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJMTAgMGg0MHY0MGgtNDB6IiBmaWxsPSJub25lIi8+PHBhdGggZD0iTTAgMGg0MHYxSDAuLi4iIHN0cm9rZT0iI2ZmZmZmZiIgc3Ryb2tlLW9wYWNpdHk9IjAuMDUiIGZpbGw9Im5vbmUiLz48L3N2Zz4=')] opacity-30 pointer-events-none">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- ============================================================
         SECTION 02: TECHNOLOGY (DYNAMIC BENTO GRID)
    ============================================================ --}}
    <section id="technology" class="relative bg-[#030914] py-20 overflow-hidden border-t border-white/[0.05]">

        <div
            class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNMCAwaDQwdjQwaC00MHoiIGZpbGw9Im5vbmUiLz48cGF0aCBkPSJNMCAwaDQwdjFIMC4uLiIgc3Ryb2tlPSIjZmZmZmZmIiBzdHJva2Utb3BhY2l0eT0iMC4wNSIgZmlsbD0ibm9uZSIvPjwvc3ZnPg==')] opacity-20">
        </div>

        <div class="relative z-10 mx-auto max-w-7xl px-6 lg:px-8">

            <div class="max-w-2xl transition-all duration-[1500ms] lusion-ease" x-data="{ shown: false }"
                x-init="let ob = new IntersectionObserver(e => { if (e[0].isIntersecting) shown = true; }, { threshold: 0.1, rootMargin: '0px 0px -10% 0px' });
                ob.observe($el);" :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-16'">

                <span class="text-xs font-black uppercase tracking-[0.2em] text-[#8B5CF6]">Under the hood</span>
                <h2 class="mt-4 text-4xl font-extrabold tracking-tight text-white sm:text-5xl">
                    From digital slide to <br> <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-[#06B6D4] to-[#8B5CF6]">structured
                        clinical review.</span>
                </h2>
                <p class="mt-4 text-lg text-slate-400">The platform brings case information, pathology images, and
                    AI-assisted analysis into one organized, high-performance environment.</p>
            </div>

            <div class="mt-2 grid grid-cols-1 gap-6 md:grid-cols-10 lg:gap-8" x-data="{ shown: false }"
                x-init="let ob = new IntersectionObserver(e => { if (e[0].isIntersecting) shown = true; }, { threshold: 0.1 });
                ob.observe($el);">

                <div class="group relative overflow-hidden rounded-[3rem] border border-white/10 bg-[#050B14] p-8 md:col-span-8 shadow-2xl transition-all duration-[1500ms] lusion-ease hover:-translate-y-2 hover:border-[#06B6D4]/50 hover:shadow-[0_20px_50px_rgba(6,182,212,0.15)]"
                    :class="shown ? 'opacity-100 translate-y-0 delay-100' : 'opacity-0 translate-y-24'">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-[#06B6D4]/10 to-transparent opacity-0 transition-opacity duration-700 group-hover:opacity-100">
                    </div>
                    <div class="relative z-10 flex h-full flex-col justify-between">
                        <div
                            class="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#06B6D4]/20 text-[#06B6D4] transition-transform duration-500 group-hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 3h6M10 3v4l-5.5 9.5A3 3 0 0 0 7.1 21h9.8a3 3 0 0 0 2.6-4.5L14 7V3" />
                                <path stroke-linecap="round" stroke-width="2" d="M8 14h8" />
                            </svg>
                        </div>
                        <div class="mt-12">
                            <h3 class="text-2xl font-bold text-white">AI-Assisted Analysis Engine</h3>
                            <p
                                class="mt-3 max-w-md text-slate-400 leading-relaxed group-hover:text-slate-300 transition-colors">
                                Connect the Laravel application with the trained Python model. The MIL framework analyzes
                                gigapixel slides while keeping results distinct from final professional judgment.</p>
                        </div>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-[2rem] border border-white/10 bg-[#050B14] p-8 md:col-span-4 shadow-2xl transition-all duration-[1500ms] lusion-ease hover:-translate-y-2 hover:border-[#8B5CF6]/50 hover:shadow-[0_20px_50px_rgba(139,92,246,0.15)]"
                    :class="shown ? 'opacity-100 translate-y-0 delay-300' : 'opacity-0 translate-y-24'">
                    <div
                        class="absolute inset-0 bg-gradient-to-bl from-[#8B5CF6]/10 to-transparent opacity-0 transition-opacity duration-700 group-hover:opacity-100">
                    </div>
                    <div class="relative z-10">
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-2xl bg-[#8B5CF6]/20 text-[#8B5CF6] transition-transform duration-500 group-hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 7.5A2.5 2.5 0 0 1 6.5 5h11A2.5 2.5 0 0 1 20 7.5v9a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 4 16.5v-9Z" />
                                <path stroke-linecap="round" stroke-width="2" d="M8 9h8M8 12h8M8 15h5" />
                            </svg>
                        </div>
                        <h3 class="mt-8 text-xl font-bold text-white">Case Management</h3>
                        <p class="mt-3 text-sm text-slate-400 leading-relaxed">Organize pathology cases and metadata
                            securely through a heavily structured, HIPAA-ready Laravel workflow.</p>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-[2rem] border border-white/10 bg-gradient-to-r from-[#050B14] to-[#07152F] p-8 md:col-span-12 shadow-2xl transition-all duration-[1500ms] lusion-ease hover:-translate-y-2 hover:border-[#2D6CDF]/50 hover:shadow-[0_20px_50px_rgba(45,108,223,0.2)]"
                    :class="shown ? 'opacity-100 translate-y-0 delay-500' : 'opacity-0 translate-y-24'">
                    <div
                        class="absolute inset-0 bg-gradient-to-l from-[#2D6CDF]/10 to-transparent opacity-0 transition-opacity duration-700 group-hover:opacity-100">
                    </div>
                    <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="max-w-xl">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/5 text-white backdrop-blur-md border border-white/10 transition-transform duration-500 group-hover:scale-110 group-hover:bg-white/10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 3a9 9 0 1 0 9 9" />
                                    <path stroke-linecap="round" stroke-width="2" d="M12 7v5l3 2" />
                                    <path stroke-linecap="round" stroke-width="2" d="M21 3v6h-6" />
                                </svg>
                            </div>
                            <h3 class="mt-6 text-xl font-bold text-white">Human-in-the-loop Review</h3>
                            <p class="mt-2 text-sm text-slate-400">The AI supports, but the clinician decides. The system
                                is designed to seamlessly pass AI-assisted data to the professional for final documentation.
                            </p>
                        </div>
                        <div class="mt-8 md:mt-0 flex gap-3">
                            <div class="h-16 w-2 rounded-full bg-[#06B6D4] animate-pulse"></div>
                            <div class="h-10 w-2 rounded-full bg-[#8B5CF6] animate-pulse delay-75"></div>
                            <div class="h-20 w-2 rounded-full bg-[#2D6CDF] animate-pulse delay-150"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ============================================================
         SECTION 03: WORKFLOW (HORIZONTAL GLASS SLABS)
    ============================================================ --}}
    <section id="workflow" class="relative bg-[#02050A] py-20 border-t border-white/[0.02] overflow-hidden">

        <div class="mx-auto max-w-4xl px-3 lg:px-8">

            <div class="text-center transition-all duration-[1500ms] lusion-ease" x-data="{ shown: false }"
                x-init="let ob = new IntersectionObserver(e => { if (e[0].isIntersecting) shown = true; }, { threshold: 0.1 });
                ob.observe($el);" :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-16'">

                <span class="text-xs font-black uppercase tracking-[0.2em] text-[#06B6D4]">The Pipeline</span>
                <h2 class="mt-4 text-3xl font-extrabold tracking-tight text-white sm:text-5xl">
                    A focused path from case to review.
                </h2>
                <p class="mx-auto mt-6 max-w-2xl text-lg text-slate-400">The application workflow is intentionally
                    clinical: organize the case, review the digital slide, request AI analysis, and document professional
                    judgment.</p>
            </div>

            <div class="mt-20 flex flex-col gap-6">
                @php
                    $steps = [
                        [1, 'Case Organization', 'Create the patient record and securely attach required metadata.'],
                        [2, 'Slide Upload', 'Upload gigapixel WSI files to protected, private storage.'],
                        [
                            3,
                            'AI Analysis',
                            'The Python MIL model processes patches and returns a malignancy assessment.',
                        ],
                        [
                            4,
                            'Clinical Review',
                            'The pathologist reviews the AI overlay and submits the final diagnostic report.',
                        ],
                    ];
                @endphp

                @foreach ($steps as $index => $step)
                    <div class="group relative flex flex-col md:flex-row items-start md:items-center gap-6 md:gap-10 rounded-[2rem] border border-white/5 bg-white/[0.02] p-8 md:p-10 transition-all duration-[1500ms] lusion-ease hover:-translate-y-1 hover:bg-[#050B14] hover:border-[#06B6D4]/40 hover:shadow-[0_20px_50px_rgba(6,182,212,0.15)] overflow-hidden"
                        x-data="{ shown: false }" x-init="let ob = new IntersectionObserver(e => { if (e[0].isIntersecting) shown = true; }, { threshold: 0.1, rootMargin: '0px 0px -5% 0px' });
                        ob.observe($el);"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-20'">

                        <div
                            class="absolute inset-0 bg-gradient-to-r from-[#06B6D4]/5 to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100">
                        </div>

                        <div
                            class="absolute -left-4 -top-8 text-[120px] font-black text-white/[0.02] transition-colors duration-500 group-hover:text-[#06B6D4]/10 select-none">
                            0{{ $step[0] }}
                        </div>

                        <div
                            class="relative z-10 flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl border border-white/10 bg-[#030914] shadow-xl transition-colors duration-500 group-hover:border-[#06B6D4]">
                            <span
                                class="text-xl font-black text-slate-500 transition-colors duration-500 group-hover:text-[#06B6D4]">0{{ $step[0] }}</span>
                        </div>

                        <div class="relative z-10 flex-1">
                            <h3
                                class="text-2xl font-bold text-white transition-colors duration-500 group-hover:text-[#06B6D4]">
                                {{ $step[1] }}</h3>
                            <p class="mt-2 text-base text-slate-400">{{ $step[2] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ============================================================
         SECTION 04: PLATFORM (CINEMATIC FEATURE WINDOW)
    ============================================================ --}}
    <section id="platform" class="relative bg-[#030914] py-20 border-t border-white/[0.05] overflow-hidden">

        <div class="mx-auto max-w-7xl px-6 lg:px-8">

            <div class="text-center transition-all duration-[1500ms] lusion-ease" x-data="{ shown: false }"
                x-init="let ob = new IntersectionObserver(e => { if (e[0].isIntersecting) shown = true; }, { threshold: 0.1 });
                ob.observe($el);" :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-16'">
                <h2 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl">
                    Designed around the <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-[#06B6D4] to-[#6EA8FF]">pathologist.</span>
                </h2>
                <p class="mx-auto mt-3 max-w-2xl text-lg text-slate-400">
                    We place the information that matters most in front of the professional, without turning the interface
                    into a complicated IT control panel.
                </p>
            </div>

            <div class="relative mt-12 mx-auto w-full max-w-6xl transition-all duration-[1500ms] lusion-ease"
                x-data="{ shown: false }" x-init="let ob = new IntersectionObserver(e => { if (e[0].isIntersecting) shown = true; }, { threshold: 0.1 });
                ob.observe($el);"
                :class="shown ? 'opacity-100 scale-100 translate-y-0' : 'opacity-0 scale-95 translate-y-24'">

                <div
                    class="relative flex flex-col overflow-hidden rounded-[2rem] border border-white/20 bg-[#050B14] shadow-[0_40px_100px_rgba(0,0,0,0.8)] md:block">

                    <div class="relative h-[300px] w-full group md:h-auto md:aspect-[16/9]">
                        <img src="{{ asset('image/microscope_lab_closeup.webp') }}" alt="Microscope"
                            class="absolute inset-0 h-full w-full object-cover opacity-90 transition-transform duration-[5000ms] ease-out group-hover:scale-105">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-[#050B14] via-[#050B14]/60 to-transparent md:from-[#030914] md:via-[#030914]/60">
                        </div>
                    </div>

                    <div class="relative z-10 w-full px-6 pb-8 -mt-24 md:absolute md:bottom-6 md:mt-0 md:px-6 md:pb-0">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                            <div
                                class="rounded-2xl border border-white/10 bg-[#081121]/90 p-5 backdrop-blur-xl transition-all duration-500 hover:-translate-y-2 hover:bg-white/10 hover:border-white/30 md:bg-white/5">
                                <h3 class="text-lg font-bold text-white">Structured UI</h3>
                                <p class="mt-1 text-xs text-slate-300">Clean, medical-grade interface prioritizing slide
                                    visibility over clutter.</p>
                            </div>
                            <div
                                class="rounded-2xl border border-[#06B6D4]/40 bg-[#06B6D4]/10 p-5 backdrop-blur-xl shadow-[0_0_30px_rgba(6,182,212,0.15)] transition-all duration-500 hover:-translate-y-2 hover:bg-[#06B6D4]/20">
                                <h3 class="text-lg font-bold text-white">Gigapixel Viewer</h3>
                                <p class="mt-1 text-xs text-slate-200">Deep zoom capabilities handling massive WSI formats
                                    seamlessly.</p>
                            </div>
                            <div
                                class="rounded-2xl border border-white/10 bg-[#081121]/90 p-5 backdrop-blur-xl transition-all duration-500 hover:-translate-y-2 hover:bg-white/10 hover:border-white/30 md:bg-white/5">
                                <h3 class="text-lg font-bold text-white">Clear Reporting</h3>
                                <p class="mt-1 text-xs text-slate-300">Export clinical findings paired with AI confidence
                                    scores in one click.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
         SECTION 05: FINAL CTA (DEEP CYBER GLOW HOVER)
    ============================================================ --}}
    <section
        class="group relative flex min-h-[60vh] flex-col items-center justify-center overflow-hidden bg-[#030914] py-36 text-center border-t border-white/[0.05]">

        <div
            class="absolute inset-0 z-0 bg-[radial-gradient(circle_at_center,rgba(6,182,212,0.15)_0%,transparent_60%)] opacity-0 transition-opacity duration-1000 ease-in-out group-hover:opacity-100">
        </div>
        <div
            class="absolute inset-0 z-0 bg-[radial-gradient(circle_at_center,rgba(139,92,246,0.1)_0%,transparent_70%)] opacity-0 transition-opacity duration-1000 delay-100 ease-in-out group-hover:opacity-100">
        </div>

        <div class="relative z-10 px-6 max-w-3xl transition-all duration-[1500ms] lusion-ease" x-data="{ shown: false }"
            x-init="let ob = new IntersectionObserver(e => { if (e[0].isIntersecting) shown = true; }, { threshold: 0.3 });
            ob.observe($el);" :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-16'">

            <h2 class="text-5xl font-extrabold tracking-tight text-white sm:text-7xl">
                Start your <br> clinical workflow.
            </h2>
            <p
                class="mx-auto mt-6 max-w-xl text-lg text-slate-400 group-hover:text-slate-300 transition-colors duration-700">
                Join the platform to securely manage cases and access AI-assisted digital pathology.
            </p>

            <div class="mt-10 flex justify-center">
                <a href="#platform"
                    class="relative overflow-hidden rounded-full bg-white px-10 py-4 text-base font-black text-[#030914] shadow-[0_0_40px_rgba(255,255,255,0.1)] transition-all duration-500 ease-out hover:scale-105 group-hover:shadow-[0_0_60px_rgba(6,182,212,0.4)]">
                    <span class="absolute inset-0 flex items-center justify-center">
                        <span
                            class="h-0 w-0 rounded-full bg-[#06B6D4] transition-all duration-500 ease-out group-hover:h-64 group-hover:w-64"></span>
                    </span>
                    <span
                        class="relative z-10 flex items-center gap-2 transition-colors duration-300 group-hover:text-white">
                        Enter the Platform
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 transition-transform duration-300 group-hover:translate-x-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </span>
                </a>
            </div>
        </div>
    </section>

@endsection
