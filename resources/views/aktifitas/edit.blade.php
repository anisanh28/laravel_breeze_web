<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Edit Aktivitas') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <form method="POST" action="{{ route('aktifitas.update', [$aktifitas->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="judulAktifitas" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul Aktifitas</label>
                            <input type="text" id="judulAktifitas" name="judulAktifitas"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black dark:text-gray-800 focus:border-orange-500 focus:ring focus:ring-orange-500 focus:ring-opacity-50"
                                value="{{ old('judulAktifitas', $aktifitas->judulAktifitas) }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="intruksi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                            <textarea id="intruksi" name="deskripsi"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black dark:text-gray-800 focus:border-orange-500 focus:ring focus:ring-orange-500 focus:ring-opacity-50"
                                rows="5" nullable>{{ old('deskripsi', $aktifitas->deskripsi) }}</textarea>
                        </div>

                        <!-- File Lampiran -->
                        <div class="mb-4">
                            <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lampiran</label>
                            <input type="file" id="file" name="file"
                                class="mt-1 block w-full text-black focus:border-orange-500 focus:ring focus:ring-orange-500 focus:ring-opacity-50">

                            @if($aktifitas->file)
                                <p class="text-sm text-gray-500 mt-2">
                                    File saat ini:
                                    <a href="{{ asset('storage/'.$aktifitas->file) }}" target="_blank" class="text-orange-500 underline">Lihat File</a>
                                </p>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label for="intruksi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Intruksi</label>
                            <textarea id="intruksi" name="intruksi"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black dark:text-gray-800 focus:border-orange-500 focus:ring focus:ring-orange-500 focus:ring-opacity-50"
                                rows="5" nullable>{{ old('intruksi', $aktifitas->intruksi) }}</textarea>
                        </div>

                        <!-- Tombol Update -->
                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-orange-600 hover:bg-orange-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-opacity-50">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
