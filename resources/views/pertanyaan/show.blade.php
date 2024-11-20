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
