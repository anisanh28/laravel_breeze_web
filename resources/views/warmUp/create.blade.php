<div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
    <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4 text-xl font-bold">
                Setelah mempelajari materi tersebut, coba jawablah pertanyaan berikut!
            </p>

            @if ($submateri->soal_warm_up)
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-6">
                    {{ $submateri->soal_warm_up }}
                </p>
            @endif

            <form method="POST" action="{{ route('jawabanWarmUp.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="submateri_id" value="{{ $submateri->id }}">
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                <div class="mb-4">
                    <label for="jawaban" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jawaban:</label>
                    <textarea id="jawaban" name="jawaban" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600" required></textarea>
                </div>

                <div class="mb-4">
                    <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Upload File (optional):</label>
                    <input type="file" id="file" name="file" class="mt-1 block w-full text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-700 dark:border-gray-600">
                </div>

                <div class="mb-4">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Kirim Jawaban
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
