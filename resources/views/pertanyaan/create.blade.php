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
                         <textarea id="pertanyaan" name="pertanyaan" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600" required></textarea>
                     </div>

                     <!-- Upload File (Optional) -->
                     <div class="mb-4">
                        <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Upload File (optional):</label>
                        <input type="file" id="file" name="file" class="mt-1 block w-full text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-700 dark:border-gray-600">
                    </div>

                     <!-- Input for Opsi -->
                     <div class="mb-4">
                         <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Opsi:</label>
                         <div id="opsi-container">
                             <!-- Placeholder for dynamically added opsi -->
                         </div>
                         <button type="button" id="add-opsi" class="mt-2 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
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
             </div>
         </div>
     </div>
 </div>
