<div class="flex-1 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg mb-6" id="pertanyaan-container" style="display: none;">
    @foreach($evaluasi->pertanyaan as $index => $pertanyaan)
        <div class="pertanyaan" style="display: {{ $index == 0 ? 'block' : 'none' }};">
            @include('components.pertanyaan', ['pertanyaan' => $pertanyaan])
        </div>
    @endforeach

    <!-- Navigation buttons -->
    <div class="mt-4 flex justify-between">
        <button id="prev-btn" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700" style="display: none;">
            Prev
        </button>
        <button id="next-btn" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
            Next
        </button>
    </div>
</div>
