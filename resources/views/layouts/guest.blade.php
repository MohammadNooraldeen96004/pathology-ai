@props(['subtitle' => 'SECURE AREA'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pathology AI') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-[100dvh] overflow-x-hidden bg-[#030914] text-slate-100 antialiased">

    <main class="relative min-h-[100dvh] overflow-hidden">

        {{-- Background glow --}}
        <div class="pointer-events-none absolute inset-0 overflow-hidden">

            <div class="absolute -left-40 -top-40 h-[520px] w-[520px] rounded-full bg-cyan-400/[0.06] blur-[120px]">
            </div>

            <div class="absolute -bottom-48 -right-40 h-[560px] w-[560px] rounded-full bg-blue-500/[0.05] blur-[140px]">
            </div>

            <div
                class="absolute left-[45%] top-[20%] h-[300px] w-[300px] rounded-full bg-cyan-300/[0.025] blur-[100px]">
            </div>

        </div>

        {{-- Subtle background texture --}}
        <div class="pointer-events-none absolute inset-0 opacity-[0.025]"
            style="background-image: linear-gradient(rgba(255,255,255,0.5) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.5) 1px, transparent 1px); background-size: 80px 80px;">
        </div>

        {{-- Page --}}
        <div class="relative z-10 flex min-h-[100dvh] w-full items-center justify-center px-4 py-8 sm:px-6">

            <div class="w-full max-w-md">

                {{-- Logo --}}
                <div class="mb-7 flex flex-col items-center text-center">

                    <img src="{{ asset('image/Full_logo.png') }}" alt="Pathology AI"
                        class="h-14 w-auto object-contain sm:h-16">

                    <div class="mt-3 text-[10px] font-medium tracking-[0.24em] text-slate-500">
                        {{ $subtitle }}
                    </div>

                </div>

                {{-- Card glow --}}
                <div class="group relative">

                    <div
                        class="absolute -inset-1 rounded-[2rem] bg-gradient-to-r from-cyan-400 via-[#8B5CF6] to-cyan-300 opacity-0 blur-xl transition duration-700 group-hover:opacity-40 group-hover:blur-2xl">
                    </div>

                    {{-- Card --}}
                    <section
                        class="relative rounded-[1.75rem] border border-white/[0.09] bg-[#050B14]/90 p-7 shadow-2xl backdrop-blur-xl sm:p-9">

                        {{ $slot }}

                    </section>

                </div>

            </div>

        </div>

    </main>

</body>

</html>
