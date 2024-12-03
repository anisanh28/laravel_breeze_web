<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-white leading-tight">
            {{ __('Jawaban Siswa untuk Aktifitas ') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="min-w-full bg-white dark:bg-white text-gray-900 dark:text-gray-100 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <thead class="bg-gray-100">
                            <tr class= "bg-white dark:bg-white">
                                <th class="px-2 py-3 text-left text-sm font-semibold text-gray-900 border-b">No</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 border-b">Nama Siswa</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 border-b">Jawaban</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900 border-b">File</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lembarKerja as $submission)
                                <tr class="border-t">
                                    <td class="px-2 py-3 text-sm text-gray-800 dark:text-white border-b"">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-3 text-sm text-gray-800 dark:text-white border-b"">{{ $submission->user->name }}</td>
                                    <td class="px-6 py-3 text-sm text-gray-800 dark:text-white border-b"">{{ $submission->lembar_kerja }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-800 dark:text-white border-b"">
                                        @if($submission->lampiran)
                                            <a href="{{ asset('storage/' . $submission->file) }}" class="text-blue-500" target="_blank">Lihat File</a>
                                        @else
                                            <span class="text-gray-500">Tidak ada file</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
