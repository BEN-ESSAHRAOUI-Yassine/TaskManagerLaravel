<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Task Manager</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900 font-sans antialiased">

    {{-- HEADER --}}
    @include('partials.header')

    {{-- PAGE WRAPPER --}}
    <div class="min-h-screen pt-16 flex flex-col">

        {{-- MAIN CONTENT --}}
        <main class="flex-1 w-full">
            <div class="max-w-7xl mx-auto px-6 py-8">
                @yield('content')
            </div>
        </main>

        {{-- FOOTER --}}
        @include('partials.footer')

    </div>

</body>
</html>