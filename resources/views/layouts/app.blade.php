<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pathology AI') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>


<body x-data="appUi" x-init="init()"
    class="min-h-screen bg-[#030914] font-sans text-slate-100 antialiased">

    <div class="relative min-h-screen overflow-x-hidden">

        {{-- Global background --}}
        <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden bg-[#030914]">

            {{-- Main cyan glow --}}
            <div
                class="absolute -left-48 -top-52 h-[700px] w-[700px] rounded-full
               bg-cyan-400/[0.08] blur-[150px]">
            </div>

            {{-- Deep blue glow --}}
            <div
                class="absolute -bottom-64 -right-40 h-[760px] w-[760px] rounded-full
               bg-blue-500/[0.07] blur-[170px]">
            </div>

            {{-- Violet atmospheric glow --}}
            <div
                class="absolute left-[42%] top-[18%] h-[430px] w-[430px] rounded-full
               bg-violet-500/[0.035] blur-[140px]">
            </div>

            {{-- Clinical cyan center glow --}}
            <div
                class="absolute left-[30%] top-[55%] h-[340px] w-[340px] rounded-full
               bg-[#06B6D4]/[0.025] blur-[110px]">
            </div>

            {{-- Microscopy-style texture --}}
            <div class="absolute inset-0 opacity-[0.045]"
                style="
            background-image:
                radial-gradient(circle at center, rgba(255,255,255,.10) 0.7px, transparent 0.8px);
            background-size: 22px 22px;
        ">
            </div>

            {{-- Subtle grid --}}
            <div class="absolute inset-0 opacity-[0.018]"
                style="
            background-image:
                linear-gradient(rgba(255,255,255,.35) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.35) 1px, transparent 1px);
            background-size: 96px 96px;
        ">
            </div>

            {{-- Edge vignette --}}
            <div class="absolute inset-0"
                style="
            background:
                radial-gradient(circle at center, transparent 35%, rgba(3,9,20,.35) 80%, rgba(3,9,20,.75) 100%);
        ">
            </div>

        </div>

        {{-- Global navigation --}}
        @include('layouts.navigation')


        {{-- Page header --}}
        @isset($header)
            <header class="border-b border-white/[0.06] bg-[#050B14]/55 backdrop-blur-xl">

                <div class="mx-auto max-w-7xl px-4 py-7 sm:px-6 lg:px-8">

                    <div class="app-fade-up">
                        {{ $header }}
                    </div>

                </div>

            </header>
        @endisset


        {{-- Global flash messages --}}
        @if (session('success') || session('error'))

            <div x-ref="flash" x-show="flashVisible" x-cloak x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
                class="mx-auto max-w-7xl px-4 pt-6 sm:px-6 lg:px-8">

                @if (session('success'))
                    <div
                        class="rounded-xl border border-emerald-400/20
                       bg-emerald-400/[0.06]
                       px-4 py-3 text-sm text-emerald-300
                       shadow-lg shadow-black/10">

                        {{ session('success') }}

                    </div>
                @endif


                @if (session('error'))
                    <div
                        class="rounded-xl border border-red-400/20
                       bg-red-400/[0.06]
                       px-4 py-3 text-sm text-red-300">

                        {{ session('error') }}

                    </div>
                @endif

            </div>

        @endif

        {{-- Page content --}}
        <main class="relative app-page-enter">
            {{ $slot }}
        </main>
        {{-- Global confirmation modal --}}
        <div x-show="confirmOpen" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4"
            @keydown.escape.window="cancelConfirmation()">

            {{-- Backdrop --}}
            <div x-show="confirmOpen" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="absolute inset-0 bg-black/70 backdrop-blur-sm"
                @click="cancelConfirmation()">
            </div>


            {{-- Modal --}}
            <div x-show="confirmOpen" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative z-10 w-full max-w-md
               rounded-2xl border border-white/[0.08]
               bg-[#07111D]
               p-6 shadow-2xl shadow-black/50">

                <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-red-300">
                    Confirmation Required
                </p>

                <h3 class="mt-2 text-lg font-bold text-white">
                    Continue with this action?
                </h3>

                <p class="mt-3 text-sm leading-6 text-slate-400" x-text="confirmMessage">
                </p>


                <div class="mt-6 flex justify-end gap-3">

                    <button type="button" @click="cancelConfirmation()"
                        class="rounded-xl border border-white/[0.08]
                       px-4 py-2.5 text-sm font-medium text-slate-300
                       transition hover:bg-white/[0.05]">

                        Cancel

                    </button>

                    <button type="button" @click="confirmAction()"
                        class="rounded-xl bg-red-400
                       px-4 py-2.5 text-sm font-bold text-[#030914]
                       transition hover:brightness-110">

                        Confirm

                    </button>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
