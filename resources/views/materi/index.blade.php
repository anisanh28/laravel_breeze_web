<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Materi') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Button to add new materi -->
                    <a href=" {{ route('materi.create') }}" class="inline-block px-6 py-3 bg-orange-600 text-white font-semibold rounded-lg shadow-md hover:bg-orange-700 transition-all duration-300 mb-6">
                        Tambah Materi
                    </a>

                    <!-- Grid layout for cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($materi as $materiItem)
                            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg shadow-lg transform transition-all hover:scale-105 hover:shadow-2xl p-4">
                                <div class="flex justify-between items-center mb-4">
                                    <!-- Link to submateri page when clicking the title -->
                                    <a href="{{ route('submateri.index', ['materi_id' => $materiItem->id]) }}" class="text-lg font-semibold text-gray-800 dark:text-gray-200 hover:text-orange-600 transition-all duration-300">
                                        {{ $materiItem->judulMateri }}
                                    </a>
                                </div>

                                <div class="flex justify-end space-x-4">
                                    <!-- Edit button -->
                                    <a href="{{ route('materi.edit', $materiItem->id) }}" class="text-blue-500 hover:text-blue-700 transition-all duration-300">
                                        Edit
                                    </a>

                                    <!-- Delete form -->
                                    <form action="{{ route('materi.destroy', $materiItem->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 transition-all duration-300">
                                            Hapus
                                        </button>
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
