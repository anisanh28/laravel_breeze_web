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
                    <!-- Button to add new evaluation -->
                    <a href="{{ route('evaluasi.create') }}" class="inline-block px-6 py-3 bg-orange-600 text-white font-semibold rounded-lg shadow-lg hover:bg-orange-700 transition duration-300 transform hover:scale-105 mb-6">
                        Tambah Evaluasi
                    </a>

                    <div class="space-y-6">
                        @foreach ($evaluasi as $evaluasi)
                            <div class="bg-white dark:bg-gray-700 rounded-lg shadow-lg p-6">
                                <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">{{ $evaluasi->judul_evaluasi }}</h3>
                                <p class="text-lg text-gray-600 dark:text-gray-300 mt-3">{{ $evaluasi->deskripsi_evaluasi }}</p>
                                <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                                    <p><strong class="font-semibold">Waktu Mulai:</strong> {{ \Carbon\Carbon::parse($evaluasi->start_time)->format('d M Y H:i') }}</p>
                                    <p><strong class="font-semibold">Waktu Selesai:</strong> {{ \Carbon\Carbon::parse($evaluasi->end_time)->format('d M Y H:i') }}</p>

                                    <!-- Durasi: Konversi menjadi menit -->
                                    @php
                                        // Pecah durasi menjadi array [jam, menit, detik]
                                        list($jam, $menit, $detik) = explode(":", $evaluasi->durasi);

                                        // Konversi menjadi menit
                                        $durasi_in_minutes = (intval($jam) * 60) + intval($menit) + (intval($detik) / 60);
                                    @endphp
                                    <p><strong class="font-semibold">Durasi:</strong> {{ round($durasi_in_minutes) }} menit</p>
                                </div>

                                <div class="mt-6 flex space-x-4">
                                    <!-- Detail Button -->
                                    <a href="{{ route('evaluasi.show', $evaluasi->id) }}" class="px-6 py-3 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-600 transition duration-300 transform hover:scale-105">
                                        Detail
                                    </a>

                                    <!-- Edit Button -->
                                    <a href="{{ route('evaluasi.edit', $evaluasi->id) }}" class="px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 transition duration-300 transform hover:scale-105">
                                        Edit
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('evaluasi.destroy', $evaluasi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus evaluasi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-6 py-3 bg-red-500 text-white font-semibold rounded-lg shadow-md hover:bg-red-600 transition duration-300 transform hover:scale-105">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
