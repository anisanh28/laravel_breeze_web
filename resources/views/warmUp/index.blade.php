<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $submateri->soal_warm_up }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 text-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full bg-gray-800">
                    <thead>
                        <tr>
                            <th class="py-3 px-6 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">User</th>
                            <th class="py-3 px-6 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">Jawaban</th>
                            <th class="py-3 px-6 text-left text-sm font-medium text-gray-300 uppercase tracking-wider">File</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($jawabanWarmUp->isNotEmpty())
                            @foreach ($jawabanWarmUp as $jawaban)
                                <tr class="bg-gray-700 border-b border-gray-600">
                                    <td class="py-4 px-6">{{ $jawaban->user->name }}</td>
                                    <td class="py-4 px-6">{{ $jawaban->jawaban }}</td>
                                    <td class="py-4 px-6">
                                        @if ($jawaban->file)
                                            <a href="{{ asset('storage/' . $jawaban->file) }}" target="_blank" class="text-blue-400 hover:text-blue-600 transition-all duration-300">View File</a>
                                        @else
                                            No File
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" class="py-4 px-6 text-center text-gray-300">No answers found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
