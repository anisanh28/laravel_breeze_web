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
                        $durasiArray = explode(":", $evaluasi->durasi);
                        $jam = $menit = $detik = 0;  // Nilai default

                        if (count($durasiArray) == 3) {
                            list($jam, $menit, $detik) = $durasiArray;
                        }

                        $durasi_in_minutes = (intval($jam) * 60) + intval($menit) + (intval($detik) / 60);
                        @endphp
                        <p><strong class="font-semibold">Durasi:</strong> {{ round($durasi_in_minutes) }} menit</p>

                       <p><strong class="font-semibold">Durasi:</strong> {{ round($durasi_in_minutes) }} menit</p>
                    </div>

                    <!-- Display Pertanyaan and Opsi -->
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold mb-2">Pertanyaan:</h4>
                        @foreach($pertanyaan as $pertanyaanItem)
                            <div class="mb-4">
                                <p><strong>{{ $pertanyaanItem->pertanyaan }}</strong></p>
                                <p><strong>Skor:</strong> {{ $pertanyaanItem->skor }}</p>

                                <!-- Display Opsi -->
                                <div class="ml-4 mt-2">
                                    <p class="font-semibold">Opsi:</p>
                                    @foreach($pertanyaanItem->opsi as $opsi)
                                        <div class="flex items-center space-x-2">
                                            <p>{{ $opsi->opsi }}</p>
                                            <span class="text-sm {{ $opsi->status == 1 ? 'text-green-500' : 'text-red-500' }}">
                                                {{ $opsi->status == 1 ? 'Benar' : 'Salah' }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
    @include('pertanyaan.create', ['evaluasi' => $evaluasi])

</x-app-layout>
