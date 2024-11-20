<div class="w-1/4 bg-gray-100 dark:bg-gray-900 p-6 rounded-lg shadow-lg">
    <!-- Timer -->
    <div class="text-center mb-6">
        <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">Waktu Tersisa</p>
        <div id="timer" class="text-4xl font-bold text-indigo-600">00:00</div>
    </div>

    <!-- Nomor Soal -->
    <div class="space-y-2">
        @foreach ($pertanyaan as $index => $pertanyaan)
            <div class="flex items-center">
                <button
                    class="jump-to-question text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400"
                    data-index="{{ $index }}">
                    {{ $index + 1 }}
                </button>
            </div>
        @endforeach
    </div>

    <script>
        // Melompat langsung ke nomor soal tertentu
        const jumpButtons = document.querySelectorAll('.jump-to-question');
        jumpButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                currentQuestionIndex = parseInt(e.target.dataset.index);
                updateQuestionVisibility();
            });
        });
    </script>
</div>
