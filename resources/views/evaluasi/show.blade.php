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
                    <!-- Display Evaluation Title -->
                    <h3 class="text-xl font-bold mb-4">{{ $evaluasi->judul_evaluasi }}</h3>

                    <!-- Display Evaluation Description -->
                    <p class="text-gray-700 dark:text-gray-300 mb-6">
                        <span class="font-semibold">Deskripsi:</span>
                        {{ $evaluasi->deskripsi_evaluasi }}
                    </p>

                    <div class="text-sm text-gray-600 dark:text-gray-400">
                       @php
                       list($jam, $menit, $detik) = explode(":", $evaluasi->durasi);
                       $durasi_in_minutes = (intval($jam) * 60) + intval($menit) + (intval($detik) / 60);
                       @endphp
                       <p><strong class="font-semibold">Durasi:</strong> {{ round($durasi_in_minutes) }} menit</p>
                    </div>

                    {{-- <!-- Add Question Button -->
                    <div class="mt-6">
                        <a href="{{ route('pertanyaan.create', ['evaluasi_id' => $evaluasi->id]) }}" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-300 transform hover:scale-105">
                            Tambah Pertanyaan
                        </a>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    @include('pertanyaan.create', ['evaluasi' => $evaluasi])

</x-app-layout>
