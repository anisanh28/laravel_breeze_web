<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Materi') }}
        </h2>
    </x-slot>

    <div class="py-4" style="background: linear-gradient(to bottom, #e0f7fa, #ffffff);">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @foreach ($materi as $index => $materiItem)
                        <div x-data="{ open: false }" class="my-4">
                            <!-- Materi Card Header -->
                            <div @click="open = !open"
                                class="cursor-pointer flex justify-between items-center bg-teal-500 p-4 rounded-lg hover:bg-teal-500">
                                <span class="text-white text-lg">{{ $materiItem->judulMateri }}</span>
                                <span x-show="!open" class="text-white">+</span>
                                <span x-show="open" class="text-white">-</span>
                            </div>

                            <!-- Submateri Section -->
                            <div x-show="open" x-collapse
                                class="mt-2 ml-6 border-l-2 border-teal-300 pl-4 bg-teal-50 rounded">
                                @if (isset($materiItem->submateri) && $materiItem->submateri->isNotEmpty())
                                    @foreach ($materiItem->submateri as $submateri)
                                        <div class="py-2">
                                            <!-- Add link to submateri detail -->
                                            <a href="{{ route('submateri.show', ['materi' => $materiItem->id, 'submateri' => $submateri->id]) }}"
                                                class="text-sm text-teal-700 hover:underline">
                                                {{ $submateri->judulSubMateri }}
                                            </a>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-sm text-gray-500">No sub-materials available.</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
