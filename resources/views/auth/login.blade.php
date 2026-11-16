<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pathology AI') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-[100dvh] overflow-hidden bg-[#030914] text-slate-100 antialiased">

    <main class="relative min-h-[100dvh] overflow-hidden">

        {{-- Background atmosphere --}}
        <div class="pointer-events-none absolute inset-0 overflow-hidden">

            <div class="absolute -left-48 -top-48 h-[650px] w-[650px] rounded-full bg-cyan-400/[0.055] blur-[140px]">
            </div>

            <div
                class="absolute -bottom-56 -right-48 h-[650px] w-[650px] rounded-full bg-blue-500/[0.045] blur-[150px]">
            </div>

            <div class="absolute left-[38%] top-[25%] h-[350px] w-[350px] rounded-full bg-cyan-300/[0.02] blur-[120px]">
            </div>

        </div>


        {{-- Subtle grid --}}
        <div class="pointer-events-none absolute inset-0 opacity-[0.025]"
            style="background-image: linear-gradient(rgba(255,255,255,0.5) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.5) 1px, transparent 1px); background-size: 80px 80px;">
        </div>


        {{-- Main content --}}
        <div class="relative z-10 flex min-h-[100dvh] w-full items-center">

            <div
                class="mx-auto grid w-full max-w-[1500px] grid-cols-1 items-center gap-12 px-6 py-8 lg:grid-cols-2 lg:px-12 xl:gap-24">

                {{-- ================================================= --}}
                {{-- LEFT SIDE --}}
                {{-- ================================================= --}}

                <section class="hidden lg:block">

                    <div class="max-w-xl">

                        {{-- Logo --}}
                        <div class="mb-10">
                            <img src="{{ asset('image/Full_logo.png') }}" alt="Pathology AI"
                                class="h-16 w-auto object-contain">
                        </div>


                        <div class="space-y-6">

                            <div>
                                <div
                                    class="mb-4 inline-flex items-center gap-2 rounded-full border border-cyan-300/10 bg-cyan-300/[0.04] px-3 py-1.5">
                                    <span class="h-1.5 w-1.5 rounded-full bg-cyan-300"></span>

                                    <span class="text-[10px] font-medium tracking-[0.2em] text-cyan-300/80">
                                        CLINICAL AI WORKSPACE
                                    </span>
                                </div>

                                <h1
                                    class="max-w-xl text-4xl font-semibold leading-[1.08] tracking-[-0.04em] text-white xl:text-5xl">
                                    Intelligent pathology,
                                    <span class="text-cyan-300">built for clinical precision.</span>
                                </h1>
                            </div>

                            <p class="max-w-lg text-sm leading-7 text-slate-400 xl:text-base">
                                A secure workspace for pathology professionals to manage cases,
                                review digital slides, and work alongside AI-assisted analysis.
                            </p>

                        </div>


                        {{-- Clinical visual --}}
                        <div class="mt-12 flex items-center gap-5">

                            <div
                                class="relative flex h-20 w-20 items-center justify-center rounded-2xl border border-white/[0.08] bg-white/[0.025]">

                                <div class="absolute inset-3 rounded-full border border-cyan-300/10"></div>

                                <div
                                    class="h-8 w-8 rounded-full border border-cyan-300/30 bg-cyan-300/[0.06] shadow-[0_0_30px_rgba(34,211,238,0.08)]">
                                </div>

                            </div>

                            <div>
                                <p class="text-xs font-medium text-slate-300">
                                    Secure clinical environment
                                </p>

                                <p class="mt-1 text-xs leading-5 text-slate-500">
                                    Designed for controlled access and professional pathology workflows.
                                </p>
                            </div>

                        </div>

                    </div>

                </section>


                {{-- ================================================= --}}
                {{-- RIGHT SIDE --}}
                {{-- ================================================= --}}

                <section class="flex w-full justify-center lg:justify-end">

                    <div class="w-full max-w-[440px]">

                        {{-- Mobile logo --}}
                        <div class="mb-8 flex justify-center lg:hidden">
                            <img src="{{ asset('image/Full_logo.png') }}" alt="Pathology AI" class="h-14 w-auto">
                        </div>


                        {{-- Card --}}
                        <div class="group relative">

                            <div
                                class="absolute -inset-1 rounded-[2rem] bg-gradient-to-r from-cyan-400 via-[#8B5CF6] to-cyan-300 opacity-0 blur-2xl transition duration-700 group-hover:opacity-25">
                            </div>


                            <div
                                class="relative rounded-[1.75rem] border border-white/[0.09] bg-[#050B14]/90 p-7 shadow-2xl backdrop-blur-xl sm:p-9">

                                {{-- Header --}}
                                <div class="mb-8">

                                    <div
                                        class="mb-4 flex h-10 w-10 items-center justify-center rounded-xl border border-cyan-300/10 bg-cyan-300/[0.05]">

                                        <svg class="h-5 w-5 text-cyan-300" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.7">

                                            <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                            <path
                                                d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-1.42 1.42-.06-.06a1.7 1.7 0 0 0-1.88-.34 1.7 1.7 0 0 0-1.03 1.56V19.6h-2v-.08a1.7 1.7 0 0 0-1.03-1.56 1.7 1.7 0 0 0-1.88.34l-.06.06-1.42-1.42.06-.06A1.7 1.7 0 0 0 9.4 15a1.7 1.7 0 0 0-1.56-1.03H7.76v-2h.08A1.7 1.7 0 0 0 9.4 10a1.7 1.7 0 0 0-.34-1.88L9 8.06l1.42-1.42.06.06A1.7 1.7 0 0 0 12.36 7.04 1.7 1.7 0 0 0 13.4 5.48V5.4h2v.08a1.7 1.7 0 0 0 1.03 1.56 1.7 1.7 0 0 0 1.88-.34l.06-.06 1.42 1.42-.06.06A1.7 1.7 0 0 0 19.4 10c.12.47.5.83.97.97h.08v2h-.08A1.7 1.7 0 0 0 19.4 15Z" />

                                        </svg>

                                    </div>

                                    <h2 class="text-2xl font-semibold tracking-[-0.025em] text-white">
                                        Welcome back
                                    </h2>

                                    <p class="mt-2 text-sm leading-6 text-slate-400">
                                        Sign in to access your clinical workspace.
                                    </p>

                                </div>


                                {{-- Form --}}
                                <form method="POST" action="{{ route('login') }}" class="space-y-5">

                                    @csrf


                                    {{-- Email --}}
                                    <div>

                                        <label for="email"
                                            class="mb-2 block text-xs font-medium tracking-wide text-slate-300">
                                            Clinical email
                                        </label>

                                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                                            novalidate autofocus autocomplete="username" placeholder="doctor@hospital.org"
                                            @class([
                                                'block w-full rounded-xl border bg-[#0b1520] px-4 py-3.5 text-sm text-white placeholder:text-slate-600 outline-none transition duration-200',
                                                'border-red-400/70 focus:border-red-400 focus:ring-4 focus:ring-red-400/[0.08]' => $errors->has(
                                                    'email'),
                                                'border-white/[0.10] focus:border-cyan-300/50 focus:ring-4 focus:ring-cyan-300/[0.07]' => !$errors->has(
                                                    'email'),
                                            ])>

                                        <x-auth-error-field field="email" />

                                    </div>


                                    {{-- Password --}}
                                    <div>

                                        <div class="mb-2 flex items-center justify-between">

                                            <label for="password"
                                                class="block text-xs font-medium tracking-wide text-slate-300">
                                                Password
                                            </label>

                                            @if (Route::has('password.request'))
                                                <a href="{{ route('password.request') }}"
                                                    class="text-xs text-slate-500 transition hover:text-cyan-300">
                                                    Forgot password?
                                                </a>
                                            @endif

                                        </div>


                                        <input id="password" type="password" name="password" novalidate
                                            autocomplete="current-password" placeholder="Enter your password"
                                            @class([
                                                'block w-full rounded-xl border bg-[#0b1520] px-4 py-3.5 text-sm text-white placeholder:text-slate-600 outline-none transition duration-200',
                                                'border-red-400/70 focus:border-red-400 focus:ring-4 focus:ring-red-400/[0.08]' => $errors->has(
                                                    'password'),
                                                'border-white/[0.10] focus:border-cyan-300/50 focus:ring-4 focus:ring-cyan-300/[0.07]' => !$errors->has(
                                                    'password'),
                                            ])>

                                        <x-auth-error-field field="password" />

                                    </div>


                                    {{-- Remember --}}
                                    <div class="flex items-center">

                                        <label class="flex cursor-pointer items-center gap-3">

                                            <input id="remember" type="checkbox" name="remember"
                                                class="h-4 w-4 rounded border-white/20 bg-[#0b1520] text-cyan-300 focus:ring-cyan-300/20">

                                            <span class="text-xs text-slate-400">
                                                Keep me signed in
                                            </span>

                                        </label>

                                    </div>


                                    {{-- Submit --}}
                                    <button type="submit"
                                        class="group/btn flex w-full items-center justify-center gap-3 rounded-xl bg-cyan-300 px-5 py-3.5 text-sm font-semibold text-[#061017] shadow-lg shadow-cyan-300/10 transition duration-200 hover:bg-cyan-200 focus:outline-none focus:ring-4 focus:ring-cyan-300/20">

                                        <span>
                                            Sign in to workspace
                                        </span>

                                        <svg class="h-4 w-4 transition-transform duration-200 group-hover/btn:translate-x-0.5"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">

                                            <path d="M5 12h14M13 6l6 6-6 6" />

                                        </svg>

                                    </button>

                                </form>


                                <div class="mt-7 border-t border-white/[0.07] pt-5 text-center">

                                    <p class="text-[11px] leading-5 text-slate-600">
                                        Authorized clinical access only
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </section>

            </div>

        </div>

    </main>

</body>

</html>
