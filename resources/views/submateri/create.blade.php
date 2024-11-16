<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Tambah SubMateri') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('submateri.store', $materi_id)}}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="judulSubMateri" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul SubMateri</label>
                            <input type="text" id="judulSubMateri" name="judulSubMateri" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" required>
                        </div>
                        <div class="mb-4">
                            <label for="tujuanPembelajaran" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tujuan Pembelajaran</label>
                            <input type="text" id="tujuanPembelajaran" name="tujuanPembelajaran" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" required>
                        </div>
                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Content Pembelajaran</label>
                            <input type="text" id="content" name="content" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" required>
                        </div>
                        <div class="mb-4">
                            <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lampiran</label>
                            <input type="file" id="file" name="file" class="mt-1 block w-full text-black focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" required>
                        </div>
                        <button type="submit" class="mt-4 bg-orange-600 text-white px-4 py-2 rounded-md hover:bg-orange-700">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
