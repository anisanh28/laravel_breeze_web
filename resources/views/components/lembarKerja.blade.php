<div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
    <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <form method="POST" action="{{ route('lembarKerja.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="aktifitas_id" value="{{ $aktifitas->id }}">
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                <div class="mb-6">
                    <label for="lembar_kerja" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jawaban:</label>
                    <textarea id="lembar_kerja" name="lembar_kerja" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600" required></textarea>
                </div>

                <div class="mb-6">
                    <label for="lampiran" class="block text-sm font-medium text-gray-700 dark:text-gray-300"> (optional):</label>
                    <input type="lampiran" id="lampiran" name="lampiran" class="mt-1 block w-full text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-700 dark:border-gray-600">
                </div>
            </form>
        </div>
    </div>
</div>
