<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="@yield('description', 'AI-assisted digital pathology platform')">

    <meta name="theme-color" content="#030914">

    <title>
        @yield('title', 'Pathology AI')
    </title>

    {{-- =====================================================
         Typography
         ===================================================== --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- =====================================================
         Assets
         ===================================================== --}}

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

</head>

<body class="min-h-screen antialiased" x-data>
    <a href="#main-content" class="sr-only focus:not-sr-only">
        Skip to content
    </a>

    {{-- Global Navigation --}}

    @include('partials.navbar')

    {{-- Page Content --}}

    <main id="main-content">
        @yield('content')
    </main>

    {{-- Global Footer --}}

    @include('partials.footer')

    @stack('scripts')

</body>

</html>
