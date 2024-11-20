<div class="w-3/4 mr-8">
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
    {{-- @foreach ($pertanyaan as $index => $pertanyaan)
        <div class="question bg-white dark:bg-gray-700 rounded-lg shadow-lg p-6 mb-4" style="display: none;">
            <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-200">{{ $index + 1 }}. {{ $pertanyaan->pertanyaan }}</h4>

            <div class="mt-4 space-y-4">
                @foreach ($pertanyaan->opsi as $opsi)
                    <div class="flex items-center">
                        <input type="radio" id="opsi{{ $opsi->id }}" name="pertanyaan{{ $pertanyaan->id }}" value="{{ $opsi->id }}" class="mr-2">
                        <label for="opsi{{ $opsi->id }}" class="text-gray-700 dark:text-gray-300">{{ $opsi->opsi }}</label>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach --}}

    <!-- Navigasi -->
    <div class="flex justify-between mt-4">
        <button id="prev-button" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700" disabled>
            Previous
        </button>
        <button id="next-button" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
            Next
        </button>
    </div>
</div>
