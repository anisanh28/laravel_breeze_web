<div class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
    <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $pertanyaan->pertanyaan }}</p>

    <!-- Cek jika ada file yang diunggah dan tampilkan -->
    @if($pertanyaan->file)
        <div class="mt-4">
            @php
                $fileExtension = pathinfo($pertanyaan->file, PATHINFO_EXTENSION);
            @endphp

            @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                <!-- Gambar -->
                <img src="{{ asset('storage/' . $pertanyaan->file) }}" alt="File Gambar" class="w-full max-w-full h-auto mt-2 rounded-md shadow-md">
            @elseif(in_array($fileExtension, ['mp4', 'mov', 'avi']))
                <!-- Video -->
                <video controls class="w-full mt-2 rounded-md shadow-md">
                    <source src="{{ asset('storage/' . $pertanyaan->file) }}" type="video/{{ $fileExtension }}">
                    Your browser does not support the video tag.
                </video>
            @else
                <!-- PDF atau file lainnya -->
                <iframe src="{{ asset('storage/' . $pertanyaan->file) }}" class="w-full mt-2 rounded-md shadow-md" style="height: 500px;"></iframe>
            @endif
        </div>
    @endif

    <!-- Opsi jawaban -->
    <ul class="list-none pl-0 mt-2">
        @foreach($pertanyaan->opsi as $opsi)
            <li class="text-gray-700 dark:text-gray-300 mt-1">
                <label class="flex items-center space-x-2">
                    <input type="radio" name="opsi_{{ $pertanyaan->id }}" value="{{ $opsi->id }}" class="mr-2">
                    <span class="text-sm sm:text-base">{{ $opsi->opsi }}</span>
                </label>
            </li>
        @endforeach
    </ul>
</div>
