<div class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-lg shadow-md">
    <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $pertanyaan->pertanyaan }}</p>

    <!-- Cek jika ada file yang diunggah dan tampilkan -->
    @if($pertanyaan->file)
        <div class="mt-4">
            <!-- Jika file adalah gambar, tampilkan gambar dengan ukuran terbatas -->
            @if(in_array(pathinfo($pertanyaan->file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                <img src="{{ asset('storage/' . $pertanyaan->file) }}" alt="File Gambar" class="max-w-xs mt-2 rounded-md shadow-md">
            @elseif(in_array(pathinfo($pertanyaan->file, PATHINFO_EXTENSION), ['mp4', 'mov', 'avi']))
                <!-- Jika file adalah video, tampilkan video -->
                <video controls class="w-full mt-2 rounded-md shadow-md">
                    <source src="{{ asset('storage/' . $pertanyaan->file) }}" type="video/{{ pathinfo($pertanyaan->file, PATHINFO_EXTENSION) }}">
                    Your browser does not support the video tag.
                </video>
            @else
                <!-- Jika file adalah dokumen lainnya, tampilkan langsung jika mendukung tampilan di browser -->
                <iframe src="{{ asset('storage/' . $pertanyaan->file) }}" class="w-full mt-2 rounded-md shadow-md" style="height: 500px;"></iframe>
            @endif
        </div>
    @endif

    <!-- Menggunakan ul tanpa nomor urut -->
    <ul class="list-none pl-0 mt-2">
        @foreach($pertanyaan->opsi as $opsi)
            <li class="text-gray-700 dark:text-gray-300 mt-1">
                <label>
                    <input type="radio" name="opsi_{{ $pertanyaan->id }}" value="{{ $opsi->id }}" class="mr-2">
                    {{ $opsi->opsi }}
                </label>
            </li>
        @endforeach
    </ul>

    <!-- Menampilkan jawaban yang benar -->
    @php
        $jawabanBenar = $pertanyaan->opsi->firstWhere('status', 1);
    @endphp
    <div class="mt-4">
        <p class="text-green-500 font-semibold">
            Jawaban Benar:
            {{ $jawabanBenar ? $jawabanBenar->opsi : 'Tidak ada jawaban benar yang ditentukan.' }}
        </p>
    </div>

    <!-- Tombol Edit dan Delete -->
    <div class="mt-4 flex space-x-4">
        <a href="{{ route('pertanyaan.edit', $pertanyaan->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Edit</a>

        <form action="{{ route('pertanyaan.destroy', $pertanyaan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Delete</button>
        </form>
    </div>
</div>
