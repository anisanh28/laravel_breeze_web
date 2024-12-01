<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-gray-200 leading-tight">
            {{ __('Evaluasi') }}
        </h2>
    </x-slot>

    <div class="py-4" style="background: linear-gradient(to bottom, #e0f7fa, #ffffff);">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="space-y-6">
                        @foreach ($evaluasi as $evaluasi)
                            <div class="bg-teal-500 dark:bg-teal-300 rounded-lg shadow-lg p-6">
                                <a href="{{ route('evaluasi.show', $evaluasi->id) }}" class="block text-xl font-semibold text-white dark:text-gray-200 hover:text-white dark:hover:text-teal-400 transition-colors duration-300">
                                    {{ $evaluasi->judul_evaluasi }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
