<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $submateri->judulSubMateri }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Submateri Title -->
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-4">
                        {{ $submateri->judulSubMateri }}
                    </h1>

                    <!-- Description Section -->
                    @if ($submateri->description)
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-6">
                            {{ $submateri->description }}
                        </p>
                    @endif

                    <!-- Embedded Media (e.g., video, image) -->
                    @if ($submateri->media)
                        <div class="mb-6">
                            @if ($submateri->media->type === 'video')
                                <video controls class="w-full rounded-lg shadow-lg">
                                    <source src="{{ asset('storage/' . $submateri->media->path) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @elseif ($submateri->media->type === 'image')
                                <img src="{{ asset('storage/' . $submateri->media->path) }}" alt="Submateri Image" class="w-full rounded-lg shadow-lg">
                            @endif
                        </div>
                    @endif

                    <!-- Additional Content -->
                    <div class="text-gray-800 dark:text-gray-200 mb-4 leading-relaxed">
                        {!! nl2br(e($submateri->content)) !!}
                    </div>

                    <!-- Back Button or Navigation -->
                    <div class="mt-8">
                        <a href="{{ route('materi.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Back to Materi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>x
</x-app-layout>
