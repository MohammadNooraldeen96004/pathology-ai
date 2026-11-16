<nav x-data="{ mobileOpen: false, profileOpen: false }" class="sticky top-0 z-50 border-b border-white/[0.06] bg-[#030914]/85 backdrop-blur-2xl">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="flex h-[72px] items-center justify-between">

            {{-- Left side --}}
            <div class="flex items-center gap-8">

                {{-- Logo --}}
                <a href="{{ route('dashboard') }}" class="group flex shrink-0 items-center">
                    <img src="{{ asset('image/Full_logo.png') }}" alt="Pathology AI"
                        class="h-10 w-auto object-contain transition duration-300 group-hover:opacity-90">
                </a>


                {{-- Desktop navigation --}}
                <div class="hidden items-center gap-1 md:flex">

                    {{-- Dashboard --}}
                    <a href="{{ route('dashboard') }}" @class([
                        'relative rounded-lg px-4 py-2 text-sm font-medium transition duration-200',
                        'bg-white/[0.06] text-white' => request()->routeIs('dashboard'),
                        'text-slate-400 hover:bg-white/[0.04] hover:text-white' => !request()->routeIs(
                            'dashboard'),
                    ])>
                        Dashboard

                        @if (request()->routeIs('dashboard'))
                            <span
                                class="absolute inset-x-4 -bottom-[17px] h-[2px] rounded-full bg-[#06B6D4] shadow-[0_0_12px_rgba(6,182,212,.7)]">
                            </span>
                        @endif
                    </a>


                    {{-- Cases --}}
                    <a href="{{ route('cases.index') }}" @class([
                        'relative rounded-lg px-4 py-2 text-sm font-medium transition duration-200',
                        'bg-white/[0.06] text-white' => request()->routeIs('cases.*'),
                        'text-slate-400 hover:bg-white/[0.04] hover:text-white' => !request()->routeIs(
                            'cases.*'),
                    ])>
                        Cases

                        @if (request()->routeIs('cases.*'))
                            <span
                                class="absolute inset-x-4 -bottom-[17px] h-[2px] rounded-full bg-[#06B6D4] shadow-[0_0_12px_rgba(6,182,212,.7)]">
                            </span>
                        @endif
                    </a>

                </div>

            </div>


            {{-- Right side --}}
            <div class="flex items-center gap-3">

                {{-- New case shortcut --}}
                <a href="{{ route('cases.create') }}"
                    class="hidden items-center justify-center rounded-xl border border-[#06B6D4]/20 bg-[#06B6D4]/[0.07] px-4 py-2.5 text-sm font-semibold text-[#67e8f9] transition duration-200 hover:border-[#06B6D4]/40 hover:bg-[#06B6D4]/[0.12] lg:inline-flex">
                    <span class="mr-2 text-lg leading-none">+</span>
                    New Case
                </a>


                {{-- Doctor profile dropdown --}}
                <div class="relative hidden sm:block" @click.outside="profileOpen = false">

                    <button type="button" @click="profileOpen = !profileOpen"
                        class="flex items-center gap-3 rounded-xl border border-white/[0.07] bg-white/[0.025] px-3 py-2 transition hover:border-white/[0.12] hover:bg-white/[0.05]">

                        {{-- Avatar --}}
                        <div
                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-[#06B6D4]/20 bg-[#06B6D4]/10 text-sm font-bold text-[#06B6D4]">
                            {{ strtoupper(substr(Auth::user()?->name ?? 'D', 0, 1)) }}
                        </div>


                        <div class="hidden text-left lg:block">

                            <div class="max-w-[160px] truncate text-sm font-semibold text-white">
                                {{ Auth::user()?->name }}
                            </div>

                            <div class="text-[11px] uppercase tracking-[0.12em] text-slate-500">
                                Pathologist
                            </div>

                        </div>


                        <svg class="h-4 w-4 text-slate-500 transition" :class="{ 'rotate-180': profileOpen }"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                clip-rule="evenodd" />
                        </svg>

                    </button>


                    {{-- Dropdown --}}
                    <div x-cloak x-show="profileOpen" x-transition.origin.top.right
                        class="absolute right-0 mt-3 w-64 overflow-hidden rounded-2xl border border-white/[0.08] bg-[#07111D]/95 p-2 shadow-2xl shadow-black/40 backdrop-blur-2xl">

                        <div class="border-b border-white/[0.06] px-3 py-3">

                            <div class="truncate text-sm font-semibold text-white">
                                {{ Auth::user()?->name }}
                            </div>

                            <div class="mt-1 truncate text-xs text-slate-500">
                                {{ Auth::user()?->email }}
                            </div>

                        </div>


                        <div class="py-2">

                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center rounded-xl px-3 py-2.5 text-sm text-slate-300 transition hover:bg-white/[0.05] hover:text-white">
                                Profile Settings
                            </a>


                            <a href="{{ route('cases.archive') }}"
                                class="flex items-center rounded-xl px-3 py-2.5 text-sm text-slate-300 transition hover:bg-white/[0.05] hover:text-white">
                                Archived Cases
                            </a>

                        </div>


                        <div class="border-t border-white/[0.06] pt-2">

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button type="submit"
                                    class="flex w-full items-center rounded-xl px-3 py-2.5 text-left text-sm text-red-300 transition hover:bg-red-400/[0.06] hover:text-red-200">
                                    Log Out
                                </button>

                            </form>

                        </div>

                    </div>

                </div>


                {{-- Mobile button --}}
                <button type="button" @click="mobileOpen = !mobileOpen"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-white/[0.08] text-slate-400 transition hover:bg-white/[0.05] hover:text-white sm:hidden"
                    aria-label="Toggle navigation">

                    <svg x-show="!mobileOpen" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M4 6h16M4 12h16M4 18h16" />
                    </svg>

                    <svg x-cloak x-show="mobileOpen" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path d="M6 18L18 6M6 6l12 12" />
                    </svg>

                </button>

            </div>

        </div>


        {{-- Mobile navigation --}}
        <div x-cloak x-show="mobileOpen" x-transition class="border-t border-white/[0.06] py-4 sm:hidden">

            <div class="space-y-1">

                <a href="{{ route('dashboard') }}" @class([
                    'block rounded-xl px-4 py-3 text-sm font-medium transition',
                    'bg-[#06B6D4]/10 text-[#06B6D4]' => request()->routeIs('dashboard'),
                    'text-slate-300 hover:bg-white/[0.05]' => !request()->routeIs('dashboard'),
                ])>
                    Dashboard
                </a>


                <a href="{{ route('cases.index') }}" @class([
                    'block rounded-xl px-4 py-3 text-sm font-medium transition',
                    'bg-[#06B6D4]/10 text-[#06B6D4]' => request()->routeIs('cases.*'),
                    'text-slate-300 hover:bg-white/[0.05]' => !request()->routeIs('cases.*'),
                ])>
                    Cases
                </a>


                <a href="{{ route('cases.create') }}"
                    class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-300 transition hover:bg-white/[0.05]">
                    New Case
                </a>


                <a href="{{ route('cases.archive') }}"
                    class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-300 transition hover:bg-white/[0.05]">
                    Archived Cases
                </a>


                <a href="{{ route('profile.edit') }}"
                    class="block rounded-xl px-4 py-3 text-sm font-medium text-slate-300 transition hover:bg-white/[0.05]">
                    Profile
                </a>

            </div>


            <div class="mt-4 border-t border-white/[0.06] pt-4">

                <div class="px-4 pb-3">

                    <div class="text-sm font-semibold text-white">
                        {{ Auth::user()?->name }}
                    </div>

                    <div class="mt-1 text-xs text-slate-500">
                        {{ Auth::user()?->email }}
                    </div>

                </div>


                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button type="submit"
                        class="block w-full rounded-xl px-4 py-3 text-left text-sm font-medium text-red-300 transition hover:bg-red-400/[0.06]">
                        Log Out
                    </button>

                </form>

            </div>

        </div>

    </div>

</nav>
