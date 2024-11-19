<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Evaluasi') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-bold mb-4">{{ $evaluasi->judul_evaluasi}}</h3>
                    <p class="text-gray-700 dark:text-gray-300 mb-6">
                        <span class="font-semibold">Deskripsi:</span>
                        {{ $evaluasi->deskripsi_evaluasi }}
                    </p>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">
                        <span class="font-semibold">Waktu Mulai:</span>
                        {{ \Carbon\Carbon::parse($evaluasi->start_time)->format('d M Y H:i') }}
                    </p>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">
                        <span class="font-semibold">Waktu Selesai:</span>
                        {{ \Carbon\Carbon::parse($evaluasi->end_time)->format('d M Y H:i') }}
                    </p>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">
                        <span class="font-semibold">Durasi:</span>
                        {{ $evaluasi->durasi }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
