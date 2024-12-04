<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-white leading-tight">
            {{ __('Submateri List') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('submateri.create', $materi_id) }}" class="inline-block px-6 py-3 bg-orange-600 text-white font-semibold rounded-lg shadow-md hover:bg-orange-700 transition-all duration-300 mb-6">
                Tambah SubMateri
            </a>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <table class="min-w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-200 dark:border-gray-700 rounded-lg">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 border-b dark:border-gray-700">Judul Submateri</th>
                                    <th class="px-4 py-2 border-b dark:border-gray-700">Tujuan Pembelajaran</th>
                                    <th class="px-4 py-2 border-b dark:border-gray-700">Content</th>
                                    <th class="px-4 py-2 border-b dark:border-gray-700">Soal Warm Up</th>
                                    <th class="px-4 py-2 border-b dark:border-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($submateri && $submateri->isNotEmpty())
                                    @foreach($submateri as $submateriItem)
                                        <tr>
                                            <td class="px-4 py-2 border-b text-sm dark:border-gray-700">{{ $submateriItem->judulSubMateri }}</td>
                                            <td class="px-4 py-2 border-b text-sm dark:border-gray-700">{{ $submateriItem->tujuanPembelajaran }}</td>
                                            <td class="px-4 py-2 border-b text-sm dark:border-gray-700">{{ $submateriItem->content }}</td>
                                            <td class="px-4 py-2 border-b text-sm dark:border-gray-700">
                                                <a href="{{ route('jawabWarmUp.index', $submateriItem->id) }}" class="text-blue-400 hover:text-blue-600 transition-all duration-300">
                                                    {{ $submateriItem->soal_warm_up }}
                                                </a>
                                            </td>
                                            <td class="px-4 py-2 text-sm border-b dark:border-gray-700 flex flex-col space-y-2">
                                                <!-- Edit Link -->
                                                <a href="{{ route('submateri.edit', $submateriItem->id) }}" class="text-blue-400 hover:text-blue-600 transition-all duration-300">
                                                    Edit
                                                </a>

                                                <!-- Delete Form -->
                                                <form action="{{ route('submateri.destroy', $submateriItem->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this submateri?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-400 hover:text-red-600 transition-all duration-300">
                                                        Delete
                                                    </button>
                                                </form>

                                                <!-- Record Aktivitas -->
                                                <a href="{{ route('waktuAkses.index', ['submateri_id' => $submateriItem->id]) }}" class="text-green-400 hover:text-green-600 transition-all duration-300">
                                                    Waktu Akses
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="py-4 px-6 text-center text-gray-300">
                                            No submateri found.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
