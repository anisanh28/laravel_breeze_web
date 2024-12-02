<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-white leading-tight">
            {{ __('Materi') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Tombol untuk menambah materi -->
                    <a href="{{ route('materi.create') }}" class="inline-block px-4 py-2 bg-orange-600 text-white font-semibold rounded-lg shadow-md hover:bg-orange-700 transition-all duration-300">
                        Tambah Materi
                    </a>
                    <table class="min-w-full mt-6 table-auto border-collapse">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-white border-b">No</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-white border-b">Judul Materi</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-white border-b">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($materi as $index => $materiItem)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="px-6 py-3 text-sm text-white border-b">{{ $index + 1 }}</td> <!-- Menambahkan No -->
                                    <td class="px-6 py-3 text-sm text-white border-b">{{ $materiItem->judulMateri }}</td>
                                    <td class="px-6 py-3 border-b flex space-x-4">
                                        <!-- Tautan untuk mengedit materi -->
                                        <a href="{{ route('materi.edit', $materiItem->id) }}" class="text-blue-500 hover:text-blue-700 transition-all duration-300">Edit</a>
                                        <!-- Form untuk menghapus materi -->
                                        <form action="{{ route('materi.destroy', $materiItem->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition-all duration-300">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
