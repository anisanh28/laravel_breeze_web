<script>
    document.getElementById('add-opsi').addEventListener('click', function () {
        const container = document.getElementById('opsi-container');
        const opsiCount = container.children.length + 1;

        // Create a new opsi input field with status radio buttons
        const newOpsi = document.createElement('div');
        newOpsi.className = 'flex items-center mb-2';
        newOpsi.innerHTML = `
            <div class="flex-1">
                <input
                    type="text"
                    name="opsi[]"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600"
                    placeholder="Opsi ${opsiCount}"
                    required
                >
            </div>
            <div class="ml-4 flex items-center">
                <input
                    type="radio"
                    name="jawaban_benar"
                    value="${opsiCount}"
                    class="mr-2"
                    required
                >
                <span class="text-sm text-gray-700 dark:text-gray-300">Benar</span>
            </div>
            <button
                type="button"
                class="ml-4 px-3 py-1 text-sm bg-red-600 text-white rounded-md hover:bg-red-700 remove-opsi focus:outline-none focus:ring-2 focus:ring-red-500">
                Hapus
            </button>
        `;

        container.appendChild(newOpsi);

        // Add event listener to remove button
        newOpsi.querySelector('.remove-opsi').addEventListener('click', function () {
            container.removeChild(newOpsi);
        });
    });
</script>
