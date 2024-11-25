<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __($evaluasi->judul_evaluasi) }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <p class="text-gray-700 dark:text-gray-300 mb-6" id="deskripsi">
                        <span class="font-semibold">Deskripsi:</span>
                        {{ $evaluasi->deskripsi_evaluasi }}
                    </p>
                    <p class="text-gray-700 dark:text-gray-300 mb-4" id="waktu-mulai">
                        <span class="font-semibold">Waktu Mulai:</span>
                        {{ \Carbon\Carbon::parse($evaluasi->start_time)->format('d M Y H:i') }}
                    </p>
                    <p class="text-gray-700 dark:text-gray-300 mb-4" id="waktu-selesai">
                        <span class="font-semibold">Waktu Selesai:</span>
                        {{ \Carbon\Carbon::parse($evaluasi->end_time)->format('d M Y H:i') }}
                    </p>
                    @php
                        list($jam, $menit, $detik) = explode(":", $evaluasi->durasi);
                        $durasi_in_seconds = (intval($jam) * 3600) + (intval($menit) * 60) + intval($detik);
                    @endphp
                    <p id="durasi" class="font-semibold mb-4"><strong class="font-semibold">Durasi:</strong> {{ round($durasi_in_seconds / 60) }} menit</p>

                    <div class="mt-6" id="mulai-btn">
                        <a href="javascript:void(0);" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700" id="start-evaluasi">
                            Mulai
                        </a>
                    </div>

                    <!-- Kontainer evaluasi -->
                    <div id="evaluasi-container" class="flex" style="display: none;">
                        <!-- Bagian kiri: Pertanyaan -->
                        <div class="flex-1 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                            @foreach($evaluasi->pertanyaan as $index => $pertanyaan)
                                <div class="pertanyaan" style="display: {{ $index == 0 ? 'block' : 'none' }};">
                                    <p class="font-semibold mb-4">Soal {{ $loop->iteration }}:</p>
                                    @include('components.pertanyaan', ['pertanyaan' => $pertanyaan])
                                </div>
                            @endforeach

                            <!-- Tombol navigasi -->
                            <div class="mt-4 flex justify-between">
                                <button id="prev-btn" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700" style="display: none;">
                                    Prev
                                </button>
                                <button id="next-btn" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                                    Next
                                </button>
                            </div>
                        </div>

                        <!-- Bagian kanan: Timer dan daftar soal -->
                        <div class="w-1/3 bg-gray-100 dark:bg-gray-700 p-6 rounded-lg shadow-lg ml-4">
                            <!-- Timer -->
                            <div id="timer" class="text-center text-lg font-semibold bg-white dark:bg-gray-800 p-4 rounded-lg mb-6 shadow-md">
                                Sisa Waktu: <span id="timer-display"></span>
                            </div>

                            <!-- Daftar soal -->
                            <div id="daftar-soal" class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
                                <p class="font-semibold mb-4">Daftar Soal:</p>
                                <div class="grid grid-cols-5 gap-2">
                                    @foreach($evaluasi->pertanyaan as $index => $pertanyaan)
                                        <button class="soal-nomor bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700" data-index="{{ $index }}">
                                            {{ $loop->iteration }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 flex justify-center" id="submit-btn-container" style="display: none;">
                        <a href="javascript:void(0);" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700" id="submit-btn">
                            Submit Evaluasi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const durasi = {{ $durasi_in_seconds }}; // Total waktu dalam detik
        let timerInterval;
        const timerDisplay = document.getElementById('timer-display');
        const questions = document.querySelectorAll('.pertanyaan');
        const questionButtons = document.querySelectorAll('.soal-nomor');
        const prevButton = document.getElementById('prev-btn');
        const nextButton = document.getElementById('next-btn');
        const submitButton = document.getElementById('submit-btn');
        const submitBtnContainer = document.getElementById('submit-btn-container');
        let currentQuestionIndex = 0;
        const answeredQuestions = new Set(); // Set untuk menyimpan nomor soal yang sudah dijawab

        // Format timer display to HH:MM:SS
        function formatTime(seconds) {
            const hours = Math.floor(seconds / 3600);
            const mins = Math.floor((seconds % 3600) / 60);
            const secs = seconds % 60;
            return `${hours.toString().padStart(2, '0')}:${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        }

        // Update question display
        function updateQuestionDisplay() {
            questions.forEach((question, index) => {
                question.style.display = (index === currentQuestionIndex) ? 'block' : 'none';
            });
            prevButton.style.display = currentQuestionIndex > 0 ? 'inline-block' : 'none';
            nextButton.style.display = currentQuestionIndex < questions.length - 1 ? 'inline-block' : 'none';
        }

        // Menandai soal yang sudah dijawab
        function markQuestionAnswered(questionIndex) {
            answeredQuestions.add(questionIndex);
            const questionButton = questionButtons[questionIndex];
            questionButton.classList.add('bg-green-500', 'hover:bg-green-600'); // Tampilkan dengan warna hijau
            questionButton.classList.remove('bg-indigo-600', 'hover:bg-indigo-700'); // Hapus warna default

            // Tampilkan tombol submit jika semua soal sudah dijawab
            if (answeredQuestions.size === questions.length) {
                submitBtnContainer.style.display = 'block';
            }
        }

        function startTimer(duration) {
            let timeRemaining = duration;
            timerDisplay.textContent = formatTime(timeRemaining);
            timerInterval = setInterval(() => {
                timeRemaining--;
                timerDisplay.textContent = formatTime(timeRemaining);
                if (timeRemaining <= 0) {
                    clearInterval(timerInterval);
                    alert("Waktu habis!");
                    submitEvaluasi();
                }
            }, 1000);
        }

        document.getElementById("start-evaluasi").addEventListener("click", function() {
            document.getElementById("deskripsi").style.display = "none";
            document.getElementById("waktu-mulai").style.display = "none";
            document.getElementById("waktu-selesai").style.display = "none";
            document.getElementById("durasi").style.display = "none";
            document.getElementById("mulai-btn").style.display = "none";
            document.getElementById("evaluasi-container").style.display = "flex";
            startTimer(durasi);
        });

        // Navigation buttons
        nextButton.addEventListener("click", function() {
            if (currentQuestionIndex < questions.length - 1) {
                currentQuestionIndex++;
                updateQuestionDisplay();
            }
        });

        prevButton.addEventListener("click", function() {
            if (currentQuestionIndex > 0) {
                currentQuestionIndex--;
                updateQuestionDisplay();
            }
        });

        // Question buttons
        questionButtons.forEach(button => {
            button.addEventListener('click', function() {
                currentQuestionIndex = parseInt(this.getAttribute('data-index'));
                updateQuestionDisplay();
            });
        });

        // Question answered event
        document.querySelectorAll('.pertanyaan').forEach((question, index) => {
            question.addEventListener('change', function() {
                markQuestionAnswered(index);
            });
        });

        function collectAnswers() {
            const answers = {};

            // Loop melalui setiap pertanyaan
            document.querySelectorAll('.pertanyaan').forEach(question => {
                const questionId = question.querySelector('input[type="radio"]').name.split('_')[1]; // Ambil ID pertanyaan dari nama input
                const selectedOption = question.querySelector('input[type="radio"]:checked'); // Ambil opsi yang dipilih

                if (selectedOption) {
                    answers[questionId] = selectedOption.value; // Simpan ID opsi yang dipilih
                }
            });

            return answers;
        }

        // Submit evaluation
        function submitEvaluasi() {
    // Mengumpulkan jawaban dari form atau elemen tertentu
    const data = collectAnswers();

    // Contoh: Menghitung waktu pengerjaan (dalam detik)
    const startTime = window.startTime || Date.now(); // Waktu mulai (pastikan diinisialisasi sebelumnya)
    const endTime = Date.now(); // Waktu saat tombol submit diklik
    const waktuPengerjaan = Math.floor((endTime - startTime) / 1000); // Konversi ke detik

    fetch("{{ route('submitEvaluasi', $evaluasi->id) }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            evaluasi_id: {{ $evaluasi->id }},
            jawaban: JSON.stringify(data),
            waktu_pengerjaan: waktuPengerjaan // Kirim waktu pengerjaan ke backend
        }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Arahkan ke halaman hasil evaluasi dengan skor
                const hasilUrl = "{{ route('evaluasi.showSkor', ':id') }}".replace(':id', data.id);
                window.location.href = hasilUrl;
            } else {
                alert('Terjadi kesalahan: ' + (data.error || ''));
            }
        })
        .catch(error => {
            console.error('Terjadi kesalahan saat mengirim data:', error);
            alert('Terjadi kesalahan jaringan.');
        });
}

        submitButton.addEventListener('click', submitEvaluasi);
    </script>
</x-app-layout>
