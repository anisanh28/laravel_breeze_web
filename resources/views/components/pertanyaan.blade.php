<div class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
    <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $pertanyaan->pertanyaan }}</p>

    <!-- Cek jika ada file yang diunggah dan tampilkan -->
    @if($pertanyaan->file)
        <div class="mt-4">
            @if(in_array(pathinfo($pertanyaan->file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                <img src="{{ asset('storage/' . $pertanyaan->file) }}" alt="File Gambar" class="max-w-xs mt-2 rounded-md shadow-md">
            @elseif(in_array(pathinfo($pertanyaan->file, PATHINFO_EXTENSION), ['mp4', 'mov', 'avi']))
                <video controls class="w-full mt-2 rounded-md shadow-md">
                    <source src="{{ asset('storage/' . $pertanyaan->file) }}" type="video/{{ pathinfo($pertanyaan->file, PATHINFO_EXTENSION) }}">
                    Your browser does not support the video tag.
                </video>
            @else
                <iframe src="{{ asset('storage/' . $pertanyaan->file) }}" class="w-full mt-2 rounded-md shadow-md" style="height: 500px;"></iframe>
            @endif
        </div>
    @endif

    <ul class="list-none pl-0 mt-2">
        @foreach($pertanyaan->opsi as $opsi)
            <li class="text-gray-700 dark:text-gray-300 mt-1">
                <label>
                    <input type="radio" name="opsi_{{ $pertanyaan->id }}" value="{{ $opsi->id }}" class="mr-2">
                    {{ $opsi->opsi }}
                </label>
            </li>
        @endforeach
        {{-- @if($pertanyaan->isEmpty())
            <p>Tidak ada pertanyaan tersedia untuk evaluasi ini.</p>
        @endif --}}
    </ul>
</div>
