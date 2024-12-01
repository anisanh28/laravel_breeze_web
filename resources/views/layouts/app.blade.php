<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <!-- Navigation -->
        <div class="fixed top-0 left-0 w-full z-50">
            @include('layouts.navigation')
        </div>

        <!-- Static Header -->
        @isset($header)
            <header class="fixed top-16 left-0 w-full bg-gradient-to-r from-teal-500 to-indigo-600 shadow z-40">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 text-white">
                    <h1 class="text-white text-lg font-semibold">{{ $header }}</h1>
                </div>
            </header>
        @endisset

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 pt-32">
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
