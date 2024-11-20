<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Evaluasi') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="space-y-6">
                        @foreach ($evaluasi as $evaluasi)
                            <div class="bg-white dark:bg-gray-700 rounded-lg shadow-lg p-6">
                                <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">{{ $evaluasi->judul_evaluasi }}</h3>

                                <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                                    <!-- Durasi: Konversi menjadi menit -->
                                    @php
                                        // Pecah durasi menjadi array [jam, menit, detik]
                                        list($jam, $menit, $detik) = explode(":", $evaluasi->durasi);

                                        // Konversi menjadi menit
                                        $durasi_in_minutes = (intval($jam) * 60) + intval($menit) + (intval($detik) / 60);
                                    @endphp
                                    <p><strong class="font-semibold">Durasi:</strong> {{ round($durasi_in_minutes) }} menit</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
