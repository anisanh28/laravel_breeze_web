<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Submateri List') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Button to create new submateri -->
            <a href="{{ route('submateri.create', $materi_id)}}" class="inline-block px-6 py-3 bg-orange-600 text-white font-semibold rounded-lg shadow-md hover:bg-orange-700 transition-all duration-300 mb-6">
                Tambah SubMateri
            </a>

            <!-- Table layout for submateri list -->
            <div class="bg-gray-800 text-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full bg-gray-800">
                    <thead>
                        <tr>
                            <th class="py-3 px-6 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">Judul Submateri</th>
                            <th class="py-3 px-6 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">Tujuan Pembelajaran</th>
                            <th class="py-3 px-6 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">Content</th>
                            <th class="py-3 px-6 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">Soal Warm Up</th>
                            <th class="py-3 px-6 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($submateri && $submateri->isNotEmpty())
                            @foreach($submateri as $submateriItem)
                                <tr class="bg-gray-700 border-b border-gray-600">
                                    <td class="py-4 px-6">{{ $submateriItem->judulSubMateri }}</td>
                                    <td class="py-4 px-6">{{ $submateriItem->tujuanPembelajaran }}</td>
                                    <td class="py-4 px-6">{{ $submateriItem->content }}</td>
                                    <td class="py-4 px-6">
                                        <a href="{{ route('jawabWarmUp.index', $submateriItem->id) }}" class="text-blue-400 hover:text-blue-600 transition-all duration-300">
                                            {{ $submateriItem->soal_warm_up }}
                                        </a>
                                    </td>
                                    <td class="py-4 px-6 flex space-x-4">
                                        <!-- Edit Link -->
                                        <a href="{{ route('submateri.edit', $submateriItem->id) }}" class="text-blue-400 hover:text-blue-600 transition-all duration-300">Edit</a>

                                        <!-- Delete Form -->
                                        <form action="{{ route('submateri.destroy', $submateriItem->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this submateri?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-600 transition-all duration-300">Delete</button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="py-4 px-6 text-center text-gray-300">No submateri found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
