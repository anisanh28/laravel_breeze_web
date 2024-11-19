<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Evaluasi') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('evaluasi.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="judul_evaluasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul Evaluasi</label>
                            <input type="text" name="judul_evaluasi" id="judul_evaluasi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" required>
                        </div>
                        <div class="mb-4">
                            <label for="deskripsi_evaluasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi Evaluasi</label>
                            <input type="text" name="deskripsi_evaluasi" id="deskripsi_evaluasi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" required>
                        </div>
                        <div class="mb-4">
                            <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Waktu Mulai</label>
                            <input type="datetime-local" name="start_time" id="start_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" required>
                        </div>
                        <div class="mb-4">
                            <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Waktu Selesai</label>
                            <input type="datetime-local" name="end_time" id="end_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" required>
                        </div>
                        <div class="mb-4">
                            <label for="durasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Durasi</label>
                            <input type="time" name="durasi" id="durasi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50" required>
                        </div>
                        <button type="submit" class="mt-4 bg-orange-600 text-white px-4 py-2 rounded-md hover:bg-orange-700">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
