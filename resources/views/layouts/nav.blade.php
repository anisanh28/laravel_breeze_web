<nav x-data="{ open: false }" class="fixed top-0 left-0 w-full bg-gradient-to-r from-teal-500 to-indigo-600 border-b border-gray-200 dark:border-gray-700 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-100" />
                    </a>
                </div>

                <!-- Navigation Links (desktop) -->
                <div class="hidden md:flex space-x-8 sm:-my-px sm:ml-10">
                    <x-nav-link href="/" :active="request()->routeIs('layouts.front')" class="text-white hover:text-teal-300">
                        {{ __('Beranda') }}
                    </x-nav-link>
                    <x-nav-link href="/tentangkami" :active="request()->routeIs('tentangkami')" class="text-white hover:text-teal-300">
                        {{ __('Tentang Kami') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings / Login & Register Buttons (desktop) -->
            <div class="hidden md:flex sm:items-center sm:ml-6">
                <div class="space-x-8">
                    <a href="{{ route('login') }}" class="text-sm text-white hover:text-teal-300">
                        {{ __('Login') }}
                    </a>
                    <a href="{{ route('register') }}" class="text-sm text-white hover:text-teal-300">
                        {{ __('Register') }}
                    </a>
                    <a href="{{ route('logout') }}" class="text-sm text-white hover:text-teal-300">
                        {{ __('Logout') }}
                    </a>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <div class="flex items-center md:hidden">
                <button @click="open = !open" class="text-gray-100 hover:text-white focus:outline-none focus:text-white">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': !open}" class="md:hidden">
        <div class="pt-2 pb-3 space-y-1 flex flex-col">
            <x-nav-link href="/" :active="request()->routeIs('layouts.front')" class="text-white hover:text-teal-300">
                {{ __('Beranda') }}
            </x-nav-link>
            <x-nav-link href="/tentangkami" :active="request()->routeIs('tentangkami')" class="text-white hover:text-teal-300">
                {{ __('Tentang Kami') }}
            </x-nav-link>
            <div class="space-y-1">
                <a href="{{ route('login') }}" class="text-sm text-white hover:text-teal-300">
                    {{ __('Login') }}
                </a>
                <a href="{{ route('register') }}" class="text-sm text-white hover:text-teal-300">
                    {{ __('Register') }}
                </a>
                <a href="{{ route('logout') }}" class="text-sm text-white hover:text-teal-300">
                    {{ __('Logout') }}
                </a>
            </div>
        </div>
    </div>
</nav>
