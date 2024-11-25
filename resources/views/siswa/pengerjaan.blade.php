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
                    <!-- Include Evaluasi Info Component -->
                    <x-evaluasi-info :evaluasi="$evaluasi" />

                    <!-- Button Start -->
                    <div class="mt-6" id="mulai-btn">
                        <a href="javascript:void(0);" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700" id="start-evaluasi">
                            Mulai
                        </a>
                    </div>

                    <!-- Include Pertanyaan Navigation Component -->
                    <x-pertanyaan :evaluasi="$evaluasi" />
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("start-evaluasi").addEventListener("click", function() {
            // Menyembunyikan deskripsi dan informasi lainnya
            document.getElementById("deskripsi").style.display = "none";
            document.getElementById("waktu-mulai").style.display = "none";
            document.getElementById("waktu-selesai").style.display = "none";
            document.getElementById("durasi").style.display = "none";
            document.getElementById("mulai-btn").style.display = "none";

            // Menampilkan pertanyaan
            document.getElementById("pertanyaan-container").style.display = "block";
        });

        let currentQuestionIndex = 0;
        const questions = document.querySelectorAll('.pertanyaan');
        const prevButton = document.getElementById('prev-btn');
        const nextButton = document.getElementById('next-btn');

        function updateQuestionDisplay() {
            // Sembunyikan semua pertanyaan
            questions.forEach((question, index) => {
                question.style.display = (index === currentQuestionIndex) ? 'block' : 'none';
            });

            // Tampilkan/selipkan tombol prev/next
            prevButton.style.display = currentQuestionIndex > 0 ? 'inline-block' : 'none';
            nextButton.style.display = currentQuestionIndex < questions.length - 1 ? 'inline-block' : 'none';
        }

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

        // Initialize the first question display
        updateQuestionDisplay();
    </script>
</x-app-layout>
