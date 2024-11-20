<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mengerjakan Evaluasi') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex p-6 text-gray-900 dark:text-gray-100">

                    <!-- Kiri: Soal dan Opsi -->
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg mb-6">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ $pertanyaan->pertanyaan }}</h3>

                        <p class="text-gray-700 dark:text-gray-300 mb-4"><strong>Skor:</strong> {{ $pertanyaan->skor }}</p>

                        <div>
                            <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Opsi:</h4>
                            @foreach($pertanyaan->opsi as $opsi)
                                <div class="mb-2">
                                    <input type="radio" id="opsi_{{ $opsi->id }}" name="opsi_{{ $pertanyaan->id }}" value="{{ $opsi->id }}" disabled>
                                    <label for="opsi_{{ $opsi->id }}" class="ml-2">{{ $opsi->opsi }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Kanan: Timer dan Nomor Soal -->
                    <div class="w-1/4 bg-gray-100 dark:bg-gray-900 p-6 rounded-lg shadow-lg">
                        <!-- Timer -->
                        <div class="text-center mb-6">
                            <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">Waktu Tersisa</p>
                            <div id="timer" class="text-4xl font-bold text-indigo-600">00:00</div>
                        </div>

                        <!-- Nomor Soal -->
                        <div class="space-y-2">
                            @foreach ($evaluasi->pertanyaan as $index => $pertanyaan)
                                <div class="flex items-center">
                                    <a href="#soal{{ $pertanyaan->id }}" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                                        <span class="text-xl">{{ $index + 1 }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Button Submit -->
                <div class="text-center mt-8">
                    <button class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700">
                        Submit Evaluasi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Timer countdown
        let timeLeft = {{ $evaluasi->durasi_in_seconds }};
        const timerElement = document.getElementById('timer');

        function updateTimer() {
            let minutes = Math.floor(timeLeft / 60);
            let seconds = timeLeft % 60;
            timerElement.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

            if (timeLeft === 0) {
                clearInterval(timerInterval);
                alert('Waktu habis!');
            } else {
                timeLeft--;
            }
        }

        const timerInterval = setInterval(updateTimer, 1000);
    </script>
</x-app-layout>
