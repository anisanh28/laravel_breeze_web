<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Tambah Aktifitas') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('aktifitas.store', $pertemuan_id)}}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="judulAktifitas" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul Aktifitas</label>
                            <input type="text" id="judulAktifitas" name="judulAktifitas" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" required>
                        </div>
                        <div class="mb-4">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                            <input type="text" id="deskripsi" name="deskripsi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" required>
                        </div>
                        <div class="mb-4">
                            <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lampiran</label>
                            <input type="file" id="file" name="file" class="mt-1 block w-full text-black focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" nullable>
                        </div>
                        <div class="mb-4">
                            <label for="intruksi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Intruksi</label>
                            <input type="text" id="intruksi" name="intruksi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" nullable>
                        </div>
                        <button type="submit" class="mt-4 bg-orange-600 text-white px-4 py-2 rounded-md hover:bg-orange-700">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
