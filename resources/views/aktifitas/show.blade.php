<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-white leading-tight">
            {{ __($pertemuan->judul) }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                @if($aktifitas && $aktifitas->isNotEmpty())
                    @foreach($aktifitas as $index => $aktifitasItem)
                        <!-- Cek apakah sudah ada jawaban -->
                        @php
                            $existingJawaban = $aktifitasItem->lembarKerja->where('user_id', auth()->id())->first();
                        @endphp

                        @if($existingJawaban)
                            <!-- Tampilkan lembarKerja.show jika sudah ada jawaban -->
                            <div class="bg-white text-black rounded-lg shadow-lg p-6 mb-4">
                                <h3 class="text-xl font-semibold mb-2">{{ $aktifitasItem->judulAktifitas }}</h3>
                                <p class="text-medium text-black mb-2">{!! nl2br(e($aktifitasItem->deskripsi)) !!}</p>
                                @if($aktifitasItem->file)
                                        <div class="flex items-start mb-4">
                                            @php
                                                $fileExtension = pathinfo($aktifitasItem->file, PATHINFO_EXTENSION);
                                            @endphp

                                            @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                                <img src="{{ asset('storage/' . $aktifitasItem->file) }}" alt="Preview Image" class="rounded-lg max-w-full sm:max-w-xs mr-4">
                                            @elseif(in_array($fileExtension, ['mp4', 'webm', 'ogg']))
                                                <video controls class="w-full max-w-[200px] rounded-lg">
                                                    <source src="{{ asset('storage/' . $aktifitasItem->file) }}" type="video/{{ $fileExtension }}">
                                                    Browser Anda tidak mendukung pemutaran video.
                                                </video>
                                            @elseif(in_array($fileExtension, ['mp3', 'wav', 'ogg']))
                                                <audio controls class="w-full">
                                                    <source src="{{ asset('storage/' . $aktifitasItem->file) }}" type="audio/{{ $fileExtension }}">
                                                    Browser Anda tidak mendukung pemutaran audio.
                                                </audio>
                                            @elseif($fileExtension === 'pdf')
                                                <embed src="{{ asset('storage/' . $aktifitasItem->file) }}" type="application/pdf" class="w-full h-96 rounded-lg">
                                            @else
                                                <a href="{{ asset('storage/' . $aktifitasItem->file) }}" class="text-orange-400 hover:text-orange-600 transition-all duration-300">
                                                    Lihat File
                                                </a>
                                            @endif
                                        </div>
                                    @endif

                                    <p class="text-medium text-black mb-4">{!! nl2br(e($aktifitasItem->intruksi)) !!}</p>
                                <p class="text-medium text-black mb-4">Jawaban yang telah Anda kirimkan:</p>

                                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                                    <p class="text-black">{{ $existingJawaban->lembar_kerja ?? 'Tidak ada jawaban' }}</p>
                                </div>

                                <!-- Tampilkan lampiran jika ada -->
                                @if($existingJawaban->lampiran)
                                    <div class="mb-4">
                                        <label class="block font-semibold">Lampiran:</label>
                                        @php
                                            $uploadedFilePath = $existingJawaban->lampiran;
                                            $fileExtension = pathinfo($uploadedFilePath, PATHINFO_EXTENSION);
                                        @endphp

                                        @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                            <img src="{{ asset('storage/' . $uploadedFilePath) }}" alt="Uploaded Image" class="rounded-lg max-w-full sm:max-w-xs">
                                        @elseif(in_array($fileExtension, ['mp4', 'webm', 'ogg']))
                                            <video controls class="w-full max-w-[200px] rounded-lg">
                                                <source src="{{ asset('storage/' . $uploadedFilePath) }}" type="video/{{ $fileExtension }}">
                                                Browser Anda tidak mendukung pemutaran video.
                                            </video>
                                        @elseif(in_array($fileExtension, ['mp3', 'wav', 'ogg']))
                                            <audio controls class="w-full">
                                                <source src="{{ asset('storage/' . $uploadedFilePath) }}" type="audio/{{ $fileExtension }}">
                                                Browser Anda tidak mendukung pemutaran audio.
                                            </audio>
                                        @elseif($fileExtension === 'pdf')
                                            <embed src="{{ asset('storage/' . $uploadedFilePath) }}" type="application/pdf" class="w-full h-96 rounded-lg">
                                        @else
                                            <a href="{{ asset('storage/' . $uploadedFilePath) }}" class="text-orange-400 hover:text-orange-600 transition-all duration-300">
                                                Lihat File
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @else
                            <!-- Tampilkan aktifitas.show jika belum ada jawaban -->
                            <form action="{{ route('lembarKerja.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="bg-white text-black rounded-lg shadow-lg p-6 mb-4">
                                    <h3 class="text-xl font-semibold mb-2">{{ $aktifitasItem->judulAktifitas }}</h3>
                                    <p class="text-medium text-black mb-2">{!! nl2br(e($aktifitasItem->deskripsi)) !!}</p>

                                    @if($aktifitasItem->file)
                                        <div class="flex items-start mb-4">
                                            @php
                                                $fileExtension = pathinfo($aktifitasItem->file, PATHINFO_EXTENSION);
                                            @endphp

                                            @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                                <img src="{{ asset('storage/' . $aktifitasItem->file) }}" alt="Preview Image" class="rounded-lg max-w-full sm:max-w-xs mr-4">
                                            @elseif(in_array($fileExtension, ['mp4', 'webm', 'ogg']))
                                                <video controls class="w-full max-w-[200px] rounded-lg">
                                                    <source src="{{ asset('storage/' . $aktifitasItem->file) }}" type="video/{{ $fileExtension }}">
                                                    Browser Anda tidak mendukung pemutaran video.
                                                </video>
                                            @elseif(in_array($fileExtension, ['mp3', 'wav', 'ogg']))
                                                <audio controls class="w-full">
                                                    <source src="{{ asset('storage/' . $aktifitasItem->file) }}" type="audio/{{ $fileExtension }}">
                                                    Browser Anda tidak mendukung pemutaran audio.
                                                </audio>
                                            @elseif($fileExtension === 'pdf')
                                                <embed src="{{ asset('storage/' . $aktifitasItem->file) }}" type="application/pdf" class="w-full h-96 rounded-lg">
                                            @else
                                                <a href="{{ asset('storage/' . $aktifitasItem->file) }}" class="text-orange-400 hover:text-orange-600 transition-all duration-300">
                                                    Lihat File
                                                </a>
                                            @endif
                                        </div>
                                    @endif

                                    <p class="text-medium text-black mb-4">{!! nl2br(e($aktifitasItem->intruksi)) !!}</p>

                                    <!-- Input Jawaban -->
                                    <textarea name="lembar_kerja[{{ $index }}]" rows="4" class="form-input w-full">{{ old('lembar_kerja.' . $index) }}</textarea>

                                    <!-- Input Lampiran -->
                                    <input type="file" name="lampiran[{{ $index }}]" class="mt-2">

                                    <input type="hidden" name="aktifitas_id[{{ $index }}]" value="{{ $aktifitasItem->id }}">
                                </div>

                                <!-- Submit Button -->
                                <div class="text-right">
                                    <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600">
                                        Kirim Semua Lembar Kerja
                                    </button>
                                </div>
                            </form>
                        @endif
                    @endforeach
                @else
                    <!-- No Activities Message -->
                    <div class="text-gray-300 text-center">
                        Tidak ada aktifitas yang ditemukan.
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
