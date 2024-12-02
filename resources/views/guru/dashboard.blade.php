<!-- resources/views/guru/dashboard.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- Selamat datang pengguna yang sedang login --}}
                    {{ __('Selamat datang guru :nama!', ['nama' => auth()->user()->name]) }}

                    {{-- Card untuk menampilkan jumlah siswa --}}
                    <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="bg-blue-500 dark:bg-blue-700 shadow-lg rounded-lg p-6 text-white text-center">
                            <h1 class="text-lg font-semibold mb-4">{{ __('Jumlah Anggota') }}</h1>
                            <p class="text-4xl font-bold">{{ $jumlahSiswa }}</p>

                            {{-- Link untuk melihat detail anggota dengan ikon anak panah --}}
                            <div class="mt-4">
                                <a href="{{ route('guru.anggota') }}" class="text-white hover:text-blue-900 flex items-center justify-center space-x-2">
                                    <span>{{ __('Lihat Anggota') }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 text-white hover:text-blue-900">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
