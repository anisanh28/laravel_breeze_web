<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-gray-200 leading-tight">
            {{ __('Hasil Evaluasi: ') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="text-gray-700 dark:text-gray-300 mb-6">
                        <span class="font-semibold">Skor yang Anda peroleh : </span> {{ $hasilEvaluasi->skor }}
                    </p>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">
                        <span class="font-semibold">Waktu Pengerjaan:</span> {{ $hasilEvaluasi->waktu_pengerjaan }} detik
                    </p>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">
                        <span class="font-semibold">Waktu Pengumpulan:</span> {{ \Carbon\Carbon::parse($hasilEvaluasi->created_at)->format('d M Y H:i') }}
                    </p>

                    <table class="min-w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <thead>
                            <tr class="bg-indigo-600 text-white">
                                <th class="px-6 py-3 text-left text-sm font-semibold border-b">No</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold border-b">Nama Pertanyaan</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold border-b">Jawaban Anda</th>
                            </tr>
                        </thead>


                        <tbody>
                            @foreach ($evaluasi->pertanyaan as $index => $pertanyaan)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="px-6 py-3 text-sm border-b">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-3 text-sm border-b">{{ $pertanyaan->pertanyaan }}</td>
                                    @php
                                        // Decode JSON string to associative array
                                        $jawabanDecoded = json_decode($hasilEvaluasi->jawaban, true);

                                        // Fetch the user's answer for the current question
                                        // If the answer is not found, use '-' as a fallback
                                        $userAnswer = $jawabanDecoded[$loop->iteration] ?? '-';
                                    @endphp
                                    <td class="px-6 py-3 text-sm border-b">
                                        {{ $userAnswer }}
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
