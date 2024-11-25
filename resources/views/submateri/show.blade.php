<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $materi->judulMateri }}
        </h2>
    </x-slot>

    <!-- Section Submateri -->
    <div class="pt-8 pb-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">
                        {{ $submateri->judulSubMateri }}
                    </h1>

                    <p class="text-l font-bold text-gray-800 dark:text-gray-200 mb-4">
                        <span class="font-medium">Tujuan Pembelajaran:</span> {{ $submateri->tujuanPembelajaran }}
                    </p>

                    @if ($submateri->description)
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-6">
                            {{ $submateri->description }}
                        </p>
                    @endif

                    @if ($submateri->file)
                        <div class="mb-6">
                            @php
                                $fileExtension = pathinfo($submateri->file, PATHINFO_EXTENSION);
                            @endphp

                            @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                <img src="{{ asset('storage/' . $submateri->file) }}" alt="Submateri Image" class="w-full rounded-lg shadow-lg">
                            @elseif (in_array($fileExtension, ['mp4', 'webm']))
                                <video controls class="w-full rounded-lg shadow-lg">
                                    <source src="{{ asset('storage/' . $submateri->file) }}" type="video/{{ $fileExtension }}">
                                    Your browser does not support the video tag.
                                </video>
                            @elseif ($fileExtension === 'pdf')
                                <embed src="{{ asset('storage/' . $submateri->file) }}" type="application/pdf" width="100%" height="500px" />
                            @elseif (in_array($fileExtension, ['doc', 'docx']))
                                <iframe src="https://docs.google.com/gview?url={{ urlencode(asset('storage/' . $submateri->file)) }}&embedded=true"
                                        width="100%" height="500px" frameborder="0">
                                </iframe>
                            @else
                                <a href="{{ asset('storage/' . $submateri->file) }}" target="_blank" class="text-indigo-500 hover:underline">
                                    Download {{ strtoupper($fileExtension) }} file
                                </a>
                            @endif
                        </div>
                    @endif


                    <div class="text-gray-800 dark:text-gray-200 mb-4 leading-relaxed">
                        {!! nl2br(e($submateri->content)) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-2 pb-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            @if ($jawabanWarmUp)
                <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg p-6">
                    <h2 class="text-gray-700 dark:text-gray-300 leading-relaxed mb-4 text-xl font-bold">
                        Jawaban Anda:
                    </h2>

                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed mb-6">
                        {{ $jawabanWarmUp->jawaban }}
                    </p>

                @if ($jawabanWarmUp->file)
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        File yang diunggah:
                    <a href="{{ asset('storage/' . $jawabanWarmUp->file) }}" target="_blank" class="text-indigo-500 hover:underline">
                        Lihat file
                </a>
            </p>
        @endif

        <!-- Tombol Edit dan Delete -->
        <div class="mt-4 flex space-x-4">
            <a href="{{ route('jawabanWarmUp.edit', $jawabanWarmUp->id) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Edit Jawaban
            </a>

            <form method="POST" action="{{ route('jawabanWarmUp.destroy', $jawabanWarmUp->id) }}">
                @csrf
                @method('DELETE')  <!-- Override method menjadi DELETE -->
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                    Hapus Jawaban
                </button>
            </form>
        </div>
    </div>
@else
    <!-- Jika belum menjawab -->
    @include('warmUp.create', ['submateri' => $submateri])
@endif

    </div>
</div>
</x-app-layout>
