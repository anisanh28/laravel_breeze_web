<x-app-layout>
    <div class="min-h-screen flex flex-col bg-gray-50 dark:bg-gray-900"> <!-- Pastikan tinggi penuh layar -->

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 flex-grow"> <!-- Tambahkan 'flex-grow' -->
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <div class="p-8">
                    <h5 class="text-xl font-extrabold text-gray-800 dark:text-gray-100 mb-6">
                        Edit Jawaban
                    </h5>

                    <label for="soal" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Soal Warm Up
                    </label>
                    @if ($submateri->soal_warm_up)
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg mb-6">
                            <p class="text-gray-600 dark:text-gray-300 text-sm">
                                {{ $submateri->soal_warm_up }}
                            </p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('jawabanWarmUp.update', $jawabanWarmUp->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <!-- Method override for updating -->

                        <input type="hidden" name="submateri_id" value="{{ $submateri->id }}">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                        <!-- Jawaban Textarea -->
                        <div class="mb-6">
                            <label for="jawaban" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Jawaban
                            </label>
                            <textarea id="jawaban" name="jawaban" rows="5" 
                                class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                                placeholder="Tulis jawaban Anda di sini..." 
                                required>{{ old('jawaban', $jawabanWarmUp->jawaban) }}</textarea>
                        </div>

                        <!-- File Upload -->
                        <div class="mb-6">
                            <label for="file" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Upload File (Opsional)
                            </label>
                            <input type="file" id="file" name="file" 
                                class="block w-full text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-700 dark:border-gray-600 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                            
                            @if ($jawabanWarmUp->file)
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                    File saat ini: 
                                    <a href="{{ asset('storage/' . $jawabanWarmUp->file) }}" 
                                       target="_blank" 
                                       class="text-indigo-500 hover:underline">
                                        Lihat file
                                    </a>
                                </p>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-6">
                            <button type="submit" 
                                class="w-full bg-indigo-600 text-white font-semibold py-3 rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Perbarui Jawaban
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
