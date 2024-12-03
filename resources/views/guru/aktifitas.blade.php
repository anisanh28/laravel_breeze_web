<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Aktifitas Siswa') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <!-- Card container -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Button to add a new meeting (inside the card) -->
                    <a href="{{ route('pertemuan.create') }}" class="inline-block px-4 py-2 bg-orange-600 text-white font-semibold rounded-lg shadow-md hover:bg-orange-700 transition-all duration-300 mb-6">
                        Tambah Pertemuan
                    </a>

                    <!-- Loop through each 'pertemuan' item and display as a card -->
                    <div class="space-y-6">
                        @foreach ($pertemuan as $pertemuanItem)
                            <div class="bg-white dark:bg-gray-600 shadow-lg rounded-lg p-6 flex justify-between items-center">
                                <!-- Title on the left, now clickable -->
                                <a href="{{ route('aktifitas.index', $pertemuanItem->id) }}" class="text-xl font-semibold text-gray-800 dark:text-gray-200 hover:underline">
                                    {{ $pertemuanItem->judul }}
                                </a>

                                <!-- Buttons on the right -->
                                <div class="flex space-x-4">
                                    <!-- Edit link -->
                                    <a href="{{ route('pertemuan.edit', $pertemuanItem->id) }}" class="text-blue-500 hover:text-blue-700 transition-all duration-300">Edit</a>

                                    <!-- Delete form -->
                                    <form action="{{ route('pertemuan.destroy', $pertemuanItem->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini?');">
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
