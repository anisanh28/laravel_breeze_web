<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ $submateri->judulSubMateri }}
        </h2>
    </x-slot>

    <!-- Latar belakang utama gradasi -->
    <div class="py-8" style="background: linear-gradient(to bottom, #3a8cae, #1c4b67);">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-teal-700 to-teal-500 shadow overflow-hidden sm:rounded-lg">
                <div class="p-6 text-white">
                    <!-- Judul Submateri -->
                    <h1 class="text-2xl font-bold text-white mb-4">
                        {{ $submateri->judulSubMateri }}
                    </h1>

                    <!-- Deskripsi -->
                    @if ($submateri->description)
                        <p class="text-gray-200 leading-relaxed mb-6">
                            {{ $submateri->description }}
                        </p>
                    @endif

                    <!-- Media Tertanam (Video/Gambar) -->
                    @if ($submateri->media)
                        <div class="mb-6">
                            @if ($submateri->media->type === 'video')
                                <video controls class="w-full rounded-lg shadow-lg">
                                    <source src="{{ asset('storage/' . $submateri->media->path) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @elseif ($submateri->media->type === 'image')
                                <img src="{{ asset('storage/' . $submateri->media->path) }}" alt="Submateri Image" class="w-full rounded-lg shadow-lg">
                            @endif
                        </div>
                    @endif

                    <!-- Konten Tambahan -->
                    <div class="text-gray-300 mb-4 leading-relaxed">
                        {!! nl2br(e($submateri->content)) !!}
                    </div>

                    <!-- Tombol Kembali -->
                    <div class="mt-8">
                        <a href="{{ route('materi.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 active:bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2">
                            Back to Materi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
