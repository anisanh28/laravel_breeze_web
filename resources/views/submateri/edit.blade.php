<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Edit SubMateri') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Edit Data SubMateri</h3>

                    <form method="POST" action="{{ route('submateri.update', [$submateri->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Judul SubMateri -->
                        <div class="mb-4">
                            <label for="judulSubMateri" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul SubMateri</label>
                            <input type="text" id="judulSubMateri" name="judulSubMateri"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black dark:text-gray-800 focus:border-orange-500 focus:ring focus:ring-orange-500 focus:ring-opacity-50"
                                value="{{ old('judulSubMateri', $submateri->judulSubMateri) }}" required>
                        </div>

                        <!-- Tujuan Pembelajaran -->
                        <div class="mb-4">
                            <label for="tujuanPembelajaran" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tujuan Pembelajaran</label>
                            <textarea id="tujuanPembelajaran" name="tujuanPembelajaran"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black dark:text-gray-800 focus:border-orange-500 focus:ring focus:ring-orange-500 focus:ring-opacity-50"
                                rows="3" required>{{ old('tujuanPembelajaran', $submateri->tujuanPembelajaran) }}</textarea>
                        </div>

                        <!-- Content Pembelajaran -->
                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Konten Pembelajaran</label>
                            <textarea id="content" name="content"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-black dark:text-gray-800 focus:border-orange-500 focus:ring focus:ring-orange-500 focus:ring-opacity-50"
                                rows="5" required>{{ old('content', $submateri->content) }}</textarea>
                        </div>

                        <!-- File Lampiran -->
                        <div class="mb-4">
                            <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lampiran</label>
                            <input type="file" id="file" name="file"
                                class="mt-1 block w-full text-black focus:border-orange-500 focus:ring focus:ring-orange-500 focus:ring-opacity-50">

                            @if($submateri->file)
                                <p class="text-sm text-gray-500 mt-2">
                                    File saat ini:
                                    <a href="{{ asset('storage/'.$submateri->file) }}" target="_blank" class="text-orange-500 underline">Lihat File</a>
                                </p>
                            @endif
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
