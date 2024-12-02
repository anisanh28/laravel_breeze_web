<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Hasil Evaluasi') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table
                        class="min-w-full bg-white dark:bg-white text-gray-900 dark:text-gray-100 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <thead>
                            <tr class="bg-white dark:bg-white">
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 border-b">No</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 border-b">Nama Siswa
                                </th>
                                @foreach ($pertanyaan as $pertanyaanItem)
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 border-b">
                                        {{ $loop->iteration }}</th>
                                @endforeach
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 border-b">Nilai</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 border-b">Lama
                                    Pengerjaan</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 border-b">Waktu
                                    Pengumpulan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hasilEvaluasi as $evaluasi)
                            <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="px-6 py-3 text-sm text-gray-800 dark:text-white border-b">{{ $loop->iteration }}</td>
                                <td class="px-6 py-3 text-sm text-gray-800 dark:text-white border-b">{{ $evaluasi->user->name }}</td>

                                @foreach ($pertanyaan as $pertanyaanItem)
                                    @php
                                        // Create a dynamic array for options with the correct option's status
                                        $options = $pertanyaanItem->opsi->sortBy('id'); // Sort options by ID to ensure the correct one comes first (optional)
                                        $correctAnswer = $options->firstWhere('status', 1); // Find the correct option

                                        // Map the user's answer (A, B, C, D, etc.) to the corresponding number (1, 2, 3, etc.)
                                        $userAnswer = $evaluasi->jawaban[$loop->index + 1] ?? '-';
                                        $userAnswerNumeric = isset($letterToNumberMap[$userAnswer]) ? $letterToNumberMap[$userAnswer] : null;

                                        // Create a new index for the options to compare with the user’s answer
                                        $optionIndex = $options->pluck('id')->flip()->mapWithKeys(function ($item, $key) {
                                        return [$key => $item + 1]; // Increment each value by 1
                                        })->toArray(); // Create a map of option id to index

                                        // Check if the user's answer matches the correct answer for this question
                                        $compareAnswer = $optionIndex[$correctAnswer->id] ?? null; // Get the index of the correct answer

                                        // Compare the user's answer to the correct one
                                        $isCorrect = ($userAnswerNumeric == $compareAnswer) ? 'bg-green-500' : 'bg-red-500';
                                    @endphp

                                    <td class="px-6 py-3 text-sm text-gray-800 dark:text-white border-b {{ $isCorrect }}">
                                        {{ $evaluasi->jawaban[$loop->index + 1] ?? '-' }}
                                    </td>

                                @endforeach
                                    <td class="px-6 py-3 text-sm text-gray-800 dark:text-white border-b">{{ $evaluasi->skor }}</td>
                                    <td class="px-6 py-3 text-sm text-gray-800 dark:text-white border-b">{{ $evaluasi->waktu_pengerjaan }}</td>
                                    <td class="px-6 py-3 text-sm text-gray-800 dark:text-white border-b">{{ $evaluasi->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <!-- Footer for displaying the percentage of correct answers -->
                        <tfoot>
                            <tr class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <td class="px-6 py-3 text-sm text-gray-800 border-b" colspan="2">Persentase</td>

                                @foreach ($pertanyaan as $pertanyaanItem)
                                    <td class="px-6 py-3 text-sm text-gray-800 border-b text-center">
                                        @php
                                            $totalJawaban = count($hasilEvaluasi);
                                            $correctJawaban = 0;

                                            foreach ($hasilEvaluasi as $evaluasi) {
                                                // Periksa apakah jawaban siswa sesuai dengan jawaban benar
                                                $options = $pertanyaanItem->opsi->sortBy('id'); // Urutkan opsi
                                                $correctAnswer = $options->firstWhere('status', 1); // Dapatkan jawaban yang benar

                                                // Ambil jawaban siswa
                                                $userAnswer = $evaluasi->jawaban[$loop->index + 1] ?? '-';
                                                $userAnswerNumeric = isset($letterToNumberMap[$userAnswer]) ? $letterToNumberMap[$userAnswer] : null;

                                                // Cari apakah jawaban siswa benar (warna hijau) atau salah (warna merah)
                                                $options = $pertanyaanItem->opsi->sortBy('id');
                                                $correctAnswerId = $correctAnswer->id ?? null;

                                                // Map opsi jawaban siswa ke dalam indeks untuk perbandingan
                                                $optionIndex = $options->pluck('id')->flip()->mapWithKeys(function ($item, $key) {
                                                    return [$key => $item + 1]; // Increment setiap value opsi
                                                })->toArray();

                                                $compareAnswer = $optionIndex[$correctAnswerId] ?? null;

                                                // Tentukan apakah jawaban benar atau salah
                                                if ($userAnswerNumeric == $compareAnswer) {
                                                    $correctJawaban++; // Jika benar, increment
                                                }
                                            }

                                            $persentase = $totalJawaban > 0 ? ($correctJawaban / $totalJawaban) * 100 : 0;
                                        @endphp

                                        {{ number_format($persentase) }}%
                                    </td>
                                @endforeach

                                <td class="px-6 py-3 text-sm text-white border-b"></td>
                                <td class="px-6 py-3 text-sm text-white border-b"></td>
                                <td class="px-6 py-3 text-sm text-white border-b"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
