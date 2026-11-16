<nav x-data="{ open: false, scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)"
    :class="scrolled ? 'bg-[#030914]/85 backdrop-blur-xl border-b border-white/[0.08] shadow-2xl' :
        'bg-transparent border-transparent'"
    class="fixed inset-x-0 top-0 z-50 transition-all duration-500">

    <div class="mx-auto flex h-20 max-w-7xl items-center justify-between px-6 lg:px-8">

        {{-- 1. Brand / Logo --}}
        <a href="{{ route('home') }}" class="group flex items-center gap-3" aria-label="Deqqa home">
            <img src="{{ asset('image/Full_logo.png') }}" alt="Logo"
                class="h-16 w-auto  transition-transform duration-300 group-hover:scale-105">
        </a>

        {{-- 2. Desktop Navigation with Strong Hover --}}
        <div class="hidden items-center gap-1 md:flex">

            <a href="{{ route('home') }}"
                class="group relative px-5 py-2.5 text-[0.85rem] font-bold uppercase tracking-wider transition-all duration-300">
                {{-- خلفية الكبسولة الزجاجية --}}
                <span
                    class="absolute inset-0 z-0 scale-75 rounded-full border border-white/0 bg-white/0 opacity-0 backdrop-blur-md transition-all duration-300 ease-out group-hover:scale-100 group-hover:border-white/10 group-hover:bg-white/[0.06] group-hover:opacity-100 group-hover:shadow-[0_8px_20px_rgba(0,0,0,0.4)]"></span>
                {{-- النص يتحول لتدرج لوني مضيء --}}

                <span
                    class="relative z-10 transition-all duration-300 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-[#6EA8FF] group-hover:to-[#E0F2FE]">Home</span>
            </a>

            <a href="{{ route('home') }}#technology"
                class="group relative px-5 py-2.5 text-[0.85rem] font-bold uppercase tracking-wider text-slate-400 transition-all duration-300">
                <span
                    class="absolute inset-0 z-0 scale-75 rounded-full border border-white/0 bg-white/0 opacity-0 backdrop-blur-md transition-all duration-300 ease-out group-hover:scale-100 group-hover:border-white/10 group-hover:bg-white/[0.06] group-hover:opacity-100 group-hover:shadow-[0_8px_20px_rgba(0,0,0,0.4)]"></span>
                <span
                    class="relative z-10 transition-all duration-300 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-[#6EA8FF] group-hover:to-[#E0F2FE]">Technology</span>
            </a>

            <a href="{{ route('home') }}#workflow"
                class="group relative px-5 py-2.5 text-[0.85rem] font-bold uppercase tracking-wider text-slate-400 transition-all duration-300">
                <span
                    class="absolute inset-0 z-0 scale-75 rounded-full border border-white/0 bg-white/0 opacity-0 backdrop-blur-md transition-all duration-300 ease-out group-hover:scale-100 group-hover:border-white/10 group-hover:bg-white/[0.06] group-hover:opacity-100 group-hover:shadow-[0_8px_20px_rgba(0,0,0,0.4)]"></span>
                <span
                    class="relative z-10 transition-all duration-300 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-[#6EA8FF] group-hover:to-[#E0F2FE]">How
                    It Works</span>
            </a>

            <a href="{{ route('home') }}#about"
                class="group relative px-5 py-2.5 text-[0.85rem] font-bold uppercase tracking-wider text-slate-400 transition-all duration-300">
                <span
                    class="absolute inset-0 z-0 scale-75 rounded-full border border-white/0 bg-white/0 opacity-0 backdrop-blur-md transition-all duration-300 ease-out group-hover:scale-100 group-hover:border-white/10 group-hover:bg-white/[0.06] group-hover:opacity-100 group-hover:shadow-[0_8px_20px_rgba(0,0,0,0.4)]"></span>
                <span
                    class="relative z-10 transition-all duration-300 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-[#6EA8FF] group-hover:to-[#E0F2FE]">About</span>
            </a>
        </div>

        {{-- 3 & 4. Desktop Buttons (Login + Explore) with Shine Effect --}}
        <div class="hidden items-center gap-4 md:flex">

            {{-- Login Button --}}
            <a href="{{  route('login')  }}"
                class="group relative overflow-hidden rounded-full border border-white/10 bg-white/[0.03] px-6 py-2.5 text-sm font-bold text-white backdrop-blur-md transition-all hover:border-[#6EA8FF]/50 hover:bg-white/10 hover:shadow-[0_0_20px_rgba(110,168,255,0.2)]">
                <span class="relative z-10">Login</span>
                {{-- Shine Animation --}}
                <div
                    class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-transform duration-700 ease-in-out group-hover:translate-x-full">
                </div>
            </a>

            {{-- Explore Platform Button --}}
            <a href="{{ route('home') }}#platform"
                class="group relative overflow-hidden rounded-full bg-[#06B6D4] px-7 py-2.5 text-sm font-bold text-[#030914] shadow-[0_0_15px_rgba(6,182,212,0.3)] transition-all duration-300 hover:shadow-[0_0_25px_rgba(6,182,212,0.5)] hover:-translate-y-0.5">
                <span class="absolute inset-0 flex items-center justify-center">
                    <span
                        class="h-0 w-0 rounded-full bg-white transition-all duration-500 ease-out group-hover:h-64 group-hover:w-64"></span>
                </span>
                <span class="relative z-10 flex items-center gap-2.5">
                    Explore Platform
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 transition-transform duration-300 ease-out group-hover:translate-x-1.5"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </span>
            </a>

        </div>

        {{-- Mobile menu button --}}
        <button type="button" @click="open = !open"
            class="flex h-10 w-10 items-center justify-center rounded-xl border border-white/10 bg-white/[0.03] text-slate-200 transition hover:bg-white/[0.07] md:hidden"
            :aria-expanded="open.toString()" aria-controls="mobile-navigation" aria-label="Toggle navigation">
            <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg x-show="open" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 6l12 12M6 18 18 6" />
            </svg>
        </button>
    </div>

    {{-- Mobile navigation --}}
    <div id="mobile-navigation" x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="border-t border-white/[0.08] bg-[#030914]/95 backdrop-blur-xl md:hidden">

        <div class="space-y-1 px-6 py-5">
            <a @click="open = false" href="{{ route('home') }}"
                class="mobile-nav-link text-slate-300 hover:text-white block py-2">Home</a>
            <a @click="open = false" href="{{ route('home') }}#technology"
                class="mobile-nav-link text-slate-300 hover:text-white block py-2">Technology</a>
            <a @click="open = false" href="{{ route('home') }}#workflow"
                class="mobile-nav-link text-slate-300 hover:text-white block py-2">How It Works</a>
            <a @click="open = false" href="{{ route('home') }}#about"
                class="mobile-nav-link text-slate-300 hover:text-white block py-2">About</a>

            <div class="mt-4 flex flex-col gap-3">
                <a @click="open = false" href="{{ route('login') }}"
                    class="flex items-center justify-center rounded-xl border border-white/10 bg-white/[0.03] px-5 py-3 text-sm font-bold text-white">
                    Login
                </a>
                <a @click="open = false" href="{{ route('home') }}#platform"
                    class="flex items-center justify-center rounded-xl bg-[#2D6CDF] px-5 py-3 text-sm font-bold text-white shadow-[0_0_15px_rgba(45,108,223,0.4)]">
                    Explore Platform
                </a>
            </div>
        </div>
    </div>
</nav>
