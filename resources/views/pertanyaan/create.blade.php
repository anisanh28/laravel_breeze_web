<div class="pt-2 pb-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                <form method="POST" action="{{ route('pertanyaan.store', $evaluasi->id) }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Hidden Field for Evaluasi ID -->
                    <input type="hidden" name="evaluasi_id" value="{{ $evaluasi->id }}">

                    <!-- Input for Pertanyaan -->
                    <div class="mb-4">
                        <label for="pertanyaan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pertanyaan:</label>
                        <input type="text" name="pertanyaan" id="pertanyaan" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600" required>
                    </div>

                    <div class="mb-4">
                        <label for="skor" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Skor</label>
                        <input type="number" name="skor" id="skor" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600" required>
                    </div>

                    <!-- Upload File (Optional) -->
                    <div class="mb-4">
                        <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Upload File (optional):</label>
                        <input type="file" id="file" name="file" class="mt-1 block w-full text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-700 dark:border-gray-600">
                    </div>

                    <!-- Input for Opsi -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Opsi:</label>
                        <div id="opsi-container" class="space-y-4">
                            <!-- Form opsi akan ditambahkan di sini -->
                        </div>
                        <button
                            type="button"
                            id="add-opsi"
                            class="mt-2 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                            Tambah Opsi
                        </button>
                    </div>

                    <!-- Submit Button -->
                    <div class="mb-4">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Tambah Pertanyaan
                        </button>
                    </div>
                </form>

                <!-- Script untuk fitur Tambah Opsi -->
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const opsiContainer = document.getElementById('opsi-container');
                        const addOpsiButton = document.getElementById('add-opsi');

                        // Event listener untuk tombol Tambah Opsi
                        addOpsiButton.addEventListener('click', function () {
                            const opsiDiv = document.createElement('div');
                            opsiDiv.className = "flex items-center space-x-4 mt-2";

                            const inputOpsi = document.createElement('input');
                            inputOpsi.type = 'text';
                            inputOpsi.name = 'opsi[]';
                            inputOpsi.placeholder = 'Masukkan Opsi';
                            inputOpsi.className = 'block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600';
                            inputOpsi.required = true;

                            const selectStatus = document.createElement('select');
                            selectStatus.name = 'status[]';
                            selectStatus.className = 'rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600';
                            selectStatus.required = true;

                            const optionTrue = document.createElement('option');
                            optionTrue.value = '1'; // Menyesuaikan dengan boolean true
                            optionTrue.textContent = 'Benar';

                            const optionFalse = document.createElement('option');
                            optionFalse.value = '0'; // Menyesuaikan dengan boolean false
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
 