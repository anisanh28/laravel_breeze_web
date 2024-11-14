<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Materi') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @foreach ($materi as $index => $materiItem)
                        <div x-data="{ open: false }" class="my-4">
                            <!-- Materi Card Header -->
                            <div @click="open = !open" class="cursor-pointer flex justify-between items-center bg-gray-700 dark:bg-gray-900 p-4 rounded-lg hover:bg-gray-600 dark:hover:bg-gray-700">
                                <span class="text-white text-lg">{{ $materiItem->judulMateri }}</span>
                                <span x-show="!open" class="text-gray-400">+</span>
                                <span x-show="open" class="text-gray-400">-</span>
                            </div>

                            <!-- Submateri Section -->
                            <div x-show="open" x-collapse class="mt-2 ml-6 border-l-2 border-gray-500 dark:border-gray-700 pl-4">
                                @if(isset($materiItem->submateri) && $materiItem->submateri->isNotEmpty())
                                    @foreach ($materiItem->submateri as $submateri)
                                        <div class="py-2">
                                            <h3 class="text-sm text-gray-300">{{ $submateri->judul }}</h3>
                                            <p class="text-xs text-gray-400 mt-1">{{ $submateri->content }}</p>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-sm text-gray-400">No sub-materials available.</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
