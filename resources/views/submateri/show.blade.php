<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $materi->judulMateri }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Submateri Title -->
                    <h1 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">
                        {{ $submateri->judulSubMateri }}
                    </h1>

                    <p class="text-l font-bold text-gray-800 dark:text-gray-200 mb-4">
                        <span class="font-medium">Tujuan Pembelajaran:</span> {{ $submateri->tujuanPembelajaran }}
                    </p>

                    <!-- Description Section -->
                    @if ($submateri->description)
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-6">
                            {{ $submateri->description }}
                        </p>
                    @endif

                    <!-- Embedded Media (e.g., image, video, pdf) -->
                    @if ($submateri->file)
                        <div class="mb-6">
                            @php
                                $fileExtension = pathinfo($submateri->file, PATHINFO_EXTENSION);
                            @endphp

                            @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                <!-- Display Image -->
                                <img src="{{ asset('storage/' . $submateri->file) }}" alt="Submateri Image" class="w-full rounded-lg shadow-lg">
                            @elseif (in_array($fileExtension, ['mp4', 'webm']))
                                <!-- Display Video -->
                                <video controls class="w-full rounded-lg shadow-lg">
                                    <source src="{{ asset('storage/' . $submateri->file) }}" type="video/{{ $fileExtension }}">
                                    Your browser does not support the video tag.
                                </video>
                            @elseif ($fileExtension === 'pdf')
                                <!-- Display PDF with embed or link to download -->
                                <embed src="{{ asset('storage/' . $submateri->file) }}" type="application/pdf" width="100%" height="500px" />
                            @else
                                <!-- For other file types, provide download link -->
                                <a href="{{ asset('storage/' . $submateri->file) }}" target="_blank" class="text-indigo-500 hover:underline">
                                    Download {{ strtoupper($fileExtension) }} file
                                </a>
                            @endif
                        </div>
                    @endif

                    <!-- Content Section -->
                    <div class="text-gray-800 dark:text-gray-200 mb-4 leading-relaxed">
                        {!! nl2br(e($submateri->content)) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
