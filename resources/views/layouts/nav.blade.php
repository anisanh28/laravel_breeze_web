<nav x-data="{ open: false }" class="bg-white fixed top-0 left-0 w-full z-50 shadow-md">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-black dark:text-black" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link href="/" :active="request()->routeIs('layouts.front')" class="text-black hover:text-black">
                        {{ __('Beranda') }}
                    </x-nav-link>
                    <x-nav-link href="/tentangkami" :active="request()->routeIs('tentangkami')" class="text-black hover:text-black">
                        {{ __('Tentang Kami') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Login & Register Buttons -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-8">
                <a href="{{ route('login') }}" class="text-sm text-black hover:text-black">
                    {{ __('Login') }}
                </a>
                <a href="{{ route('register') }}" class="text-sm text-black hover:text-black">
                    {{ __('Register') }}
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>
