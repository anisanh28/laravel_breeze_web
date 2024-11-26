<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Hasil Evaluasi: ' . $evaluasi->judul_evaluasi) }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="text-gray-700 dark:text-gray-300 mb-6">
                        <span class="font-semibold">Skor:</span> {{ $hasilEvaluasi->skor }}
                    </p>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">
                        <span class="font-semibold">Waktu Pengerjaan:</span> {{ $hasilEvaluasi->waktu_pengerjaan }} detik
                    </p>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">
                        <span class="font-semibold">Waktu Pengumpulan:</span> {{ \Carbon\Carbon::parse($hasilEvaluasi->created_at)->format('d M Y H:i') }}
                    </p>

                    <table class="min-w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-white border-b">No</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-white border-b">Nama Pertanyaan</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-white border-b">Jawaban</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-white border-b">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($evaluasi->pertanyaan as $index => $pertanyaan)
                                <tr>
                                    <td class="px-6 py-3 text-sm text-white border-b">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-3 text-sm text-white border-b">{{ $pertanyaan->judul }}</td>
                                    <td class="px-6 py-3 text-sm text-white border-b">{{ $hasilEvaluasi->jawaban[$pertanyaan->id] ?? '-' }}</td>
                                    <td class="px-6 py-3 text-sm text-white border-b">
                                        @if ($hasilEvaluasi->jawaban[$pertanyaan->id] == $pertanyaan->jawaban_benar)
                                            <span class="text-green-500">Benar</span>
                                        @else
                                            <span class="text-red-500">Salah</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
