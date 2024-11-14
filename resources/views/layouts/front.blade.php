<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('meta')

    @yield('tittle')

    @yield('style')
    <!--Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!--Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-transparent text-gray-900 antialiased">
    @include('layouts.nav')
    <!--Fonts -->
    @yield('content')
    @include('layouts.footer')
    <!--script -->
    @yield('script')
</body>
</html>
