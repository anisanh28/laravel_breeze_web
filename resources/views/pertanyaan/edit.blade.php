<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Pertanyaan') }}
        </h2>
    </x-slot>

    <div class="pt-2 pb-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('pertanyaan.update', $pertanyaan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Input Pertanyaan -->
                        <div class="mb-4">
                            <label for="pertanyaan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pertanyaan:</label>
                            <input type="text" id="pertanyaan" name="pertanyaan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600" value="{{ old('pertanyaan', $pertanyaan->pertanyaan) }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="skor" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Skor:</label>
                            <input type="number" id="skor" name="skor" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600" value="{{ old('pertanyaan', $pertanyaan->skor) }}" required>
                        </div>

                        <!-- File Terkait -->
                        <div class="mb-4">
                            <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">File (Opsional):</label>
                            <input type="file" id="file" name="file" class="mt-1 block w-full text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-700 dark:border-gray-600">
                            @if($pertanyaan->file)
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    File saat ini:
                                    <a href="{{ asset('storage/' . $pertanyaan->file) }}" target="_blank" class="text-indigo-500 hover:underline">Lihat File</a>
                                </p>
                            @endif
                        </div>

                        <!-- Opsi -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Opsi:</label>
                            <div id="opsi-container" class="space-y-4">
                                @foreach($pertanyaan->opsi as $opsi)
                                    <div class="flex items-center space-x-4">
                                        <input type="text" id="opsi_{{ $opsi->id }}" name="opsi[{{ $opsi->id }}]" placeholder="Masukkan Opsi" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600" value="{{ old('opsi.' . $opsi->id, $opsi->opsi) }}" required>

                                        <select name="status[{{ $opsi->id }}]" class="rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600" required>
                                            <option value="1" {{ $opsi->status == 1 ? 'selected' : '' }}>Benar</option>
                                            <option value="0" {{ $opsi->status == 0 ? 'selected' : '' }}>Salah</option>
                                        </select>

                                        <button type="button" class="px-3 py-2 bg-red-600 text-white rounded-md" onclick="this.parentElement.remove()">Hapus</button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-opsi" class="mt-4 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                Tambah Opsi
                            </button>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="mb-4">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                Update Pertanyaan
                            </button>
                        </div>
                    </form>

                    <!-- Script untuk Menambah Opsi -->
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const opsiContainer = document.getElementById('opsi-container');
                            const addOpsiButton = document.getElementById('add-opsi');

                            addOpsiButton.addEventListener('click', function () {
                                const opsiDiv = document.createElement('div');
                                opsiDiv.className = "flex items-center space-x-4 mt-2";

                                const inputOpsi = document.createElement('input');
                                inputOpsi.type = 'text';
                                inputOpsi.name = 'opsi[new][]';
                                inputOpsi.placeholder = 'Masukkan Opsi';
                                inputOpsi.className = 'block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600';
                                inputOpsi.required = true;

                                const selectStatus = document.createElement('select');
                                selectStatus.name = 'status[new][]';
                                selectStatus.className = 'rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600';
                                selectStatus.required = true;

                                const optionTrue = document.createElement('option');
                                optionTrue.value = '1';
                                optionTrue.textContent = 'Benar';

                                const optionFalse = document.createElement('option');
                                optionFalse.value = '0';
                                optionFalse.textContent = 'Salah';

                                selectStatus.appendChild(optionTrue);
                                selectStatus.appendChild(optionFalse);

                                const deleteButton = document.createElement('button');
                                deleteButton.type = 'button';
                                deleteButton.className = 'px-3 py-2 bg-red-600 text-white rounded-md';
                                deleteButton.textContent = 'Hapus';
                                deleteButton.addEventListener('click', function () {
                                    opsiDiv.remove();
                                });

                                opsiDiv.appendChild(inputOpsi);
                                opsiDiv.appendChild(selectStatus);
                                opsiDiv.appendChild(deleteButton);

                                opsiContainer.appendChild(opsiDiv);
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
