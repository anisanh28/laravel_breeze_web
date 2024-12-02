<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white dark:text-white leading-tight">
                {{ __('Detail Evaluasi') }}
            </h2>
            <a href="{{ route('hasilEvaluasi.index') }}" class="bg-orange-600 text-white px-4 py-2 rounded shadow hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-opacity-50">
                Lihat Hasil Evaluasi
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Display Evaluation Title -->
                    <h3 class="text-xl font-bold mb-4 text-black dark:text-black">{{ $evaluasi->judul_evaluasi }}</h3>

                    <!-- Display Evaluation Description -->
                    <p class="text-gray-700 dark:text-gray-300 mb-6">
                        <span class="font-semibold text-black dark:text-black">Deskripsi:</span>
                        {{ $evaluasi->deskripsi_evaluasi }}
                    </p>

                    <!-- Display Start and End Time -->
                    <div class="flex space-x-6 mb-6">
                        <p class="text-gray-700 dark:text-gray-300">
                            <span class="font-semibold text-black dark:text-black">Waktu Mulai:</span>
                            {{ \Carbon\Carbon::parse($evaluasi->start_time)->format('d M Y H:i') }}
                        </p>
                        <p class="text-gray-700 dark:text-gray-300">
                            <span class="font-semibold text-black dark:text-black">Waktu Selesai:</span>
                            {{ \Carbon\Carbon::parse($evaluasi->end_time)->format('d M Y H:i') }}
                        </p>
                    </div>

                    <!-- Loop through Pertanyaan and include the pertanyaan-item component -->
                    <div class="space-y-6">
                        @foreach($evaluasi->pertanyaan as $pertanyaan)
                            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-lg">
                                @include('components.pertanyaan-item', ['pertanyaan' => $pertanyaan])
                            </div>
                        @endforeach
                    </div>

                    <!-- Add New Question Button (if applicable) -->
                    @include('pertanyaan.create', ['evaluasi' => $evaluasi])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
