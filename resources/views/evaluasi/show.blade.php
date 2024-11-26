<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Evaluasi') }}
            </h2>
            <a href="{{ route('hasilEvaluasi.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600">
                Lihat Hasil Evaluasi
            </a>
        </div>
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

                    <!-- Loop through Pertanyaan and include the pertanyaan-item component -->
                    @foreach($evaluasi->pertanyaan as $pertanyaan)
                        @include('components.pertanyaan-item', ['pertanyaan' => $pertanyaan])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @include('pertanyaan.create', ['evaluasi' => $evaluasi])
</x-app-layout>
