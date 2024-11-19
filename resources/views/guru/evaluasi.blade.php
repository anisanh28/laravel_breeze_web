<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Evaluasi') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Tombol untuk menambah materi -->
                    <a href="{{ route('evaluasi.create') }}" class="inline-block px-4 py-2 bg-orange-600 text-white font-semibold rounded-lg shadow-md hover:bg-orange-700 transition-all duration-300">
                        Tambah Evaluasi
                    </a>

                    <div class="mt-6 space-y-4">
                        @foreach ($evaluasi as $evaluasi)
                            <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md p-4">
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">{{ $evaluasi->judul_evaluasi }}</h3>
                                <p class="text-gray-600 dark:text-gray-300 mt-2">{{ $evaluasi->deskripsi_evaluasi }}</p>
                                <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                                    <p><strong>Waktu Mulai:</strong> {{ $evaluasi->waktu_mulai }}</p>
                                    <p><strong>Waktu Selesai:</strong> {{ $evaluasi->waktu_selesai }}</p>
                                    <p><strong>Durasi:</strong> {{ $evaluasi->durasi }}</p>
                                </div>
                                <div class="mt-4 flex space-x-4">
                                    <!-- Tautan untuk mengedit evaluasi -->
                                    <a href="{{ route('evaluasi.edit', $evaluasi->id) }}" class="text-blue-500 hover:text-blue-700 transition-all duration-300">Edit</a>

                                    <!-- Form untuk menghapus evaluasi -->
                                    <form action="{{ route('evaluasi.destroy', $evaluasi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus evaluasi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 transition-all duration-300">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
