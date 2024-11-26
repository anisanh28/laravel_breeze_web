<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Aktifitas') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Button to create new submateri -->
            <a href="{{ route('aktifitas.create', $pertemuan_id)}}" class="inline-block px-6 py-3 bg-orange-600 text-white font-semibold rounded-lg shadow-md hover:bg-orange-700 transition-all duration-300 mb-6">
                Tambah Aktifitas
            </a>

            <!-- Cards Container -->
            <div class="space-y-6">
                @if($aktifitas && $aktifitas->isNotEmpty())
                    @foreach($aktifitas as $aktifitasItem)
                        <!-- Single Card -->
                        <div class="bg-gray-800 text-white rounded-lg shadow-lg p-6">
                            <!-- Title and Description -->
                            <h3 class="text-2xl font-semibold mb-2">{{ $aktifitasItem->judulAktifitas }}</h3>
                            <p class="text-lg text-gray-300 mb-2">{!! nl2br(e($aktifitasItem->deskripsi)) !!}</p>
                            
                            <!-- File Preview -->
                            @if($aktifitasItem->file)
                                <div class="flex items-start mb-4">
                                    @php
                                        $fileExtension = pathinfo($aktifitasItem->file, PATHINFO_EXTENSION);
                                    @endphp

                                    @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                        <!-- Image Preview -->
                                        <img src="{{ asset('storage/' . $aktifitasItem->file) }}" alt="Preview Image" class="rounded-lg max-w-xs mr-4">
                                    @elseif(in_array($fileExtension, ['mp4', 'webm', 'ogg']))
                                        <!-- Video Preview -->
                                        <video controls class="w-full max-w-[200px] rounded-lg">
                                            <source src="{{ asset('storage/' . $aktifitasItem->file) }}" type="video/{{ $fileExtension }}">
                                            Browser Anda tidak mendukung pemutaran video.
                                        </video>
                                    @elseif(in_array($fileExtension, ['mp3', 'wav', 'ogg']))
                                        <!-- Audio Preview -->
                                        <audio controls class="w-full">
                                            <source src="{{ asset('storage/' . $aktifitasItem->file) }}" type="audio/{{ $fileExtension }}">
                                            Browser Anda tidak mendukung pemutaran audio.
                                        </audio>
                                    @elseif($fileExtension === 'pdf')
                                        <!-- PDF Preview -->
                                        <embed src="{{ asset('storage/' . $aktifitasItem->file) }}" type="application/pdf" class="w-full h-96 rounded-lg">
                                    @else
                                        <!-- Fallback for Unsupported File Types -->
                                        <a href="{{ asset('storage/' . $aktifitasItem->file) }}" class="text-orange-400 hover:text-orange-600 transition-all duration-300">
                                            Lihat File
                                        </a>
                                    @endif
                                  
                                </div>
                            @endif

                            <!-- Instructions -->
                            <p class="text-lg text-gray-300 mb-4">{!! nl2br(e($aktifitasItem->intruksi)) !!}</p>

                            <!-- Buttons at the Bottom -->
                            <div class="flex justify-start space-x-4">
                                <a href="{{ route('aktifitas.edit', $aktifitasItem->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-700 transition-all duration-300">Edit</a>
                                <form action="{{ route('aktifitas.destroy', $aktifitasItem->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus aktifitas?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-700 transition-all duration-300">Delete</button>
                                </form>
                            </div>
                        </div>
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
