<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-white leading-tight">
            {{ __('Aktifitas Kelas') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <!-- Card container -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-white dark:text-white">
                    <div class="space-y-6">
                        @foreach ($pertemuan as $pertemuanItem)
                            <div class="bg-teal-500 dark:bg-teal-500 shadow-lg rounded-lg p-6 flex justify-between items-center">
                                <a href="{{ route('pertemuan.show', $pertemuanItem->id) }}" class="text-xl font-semibold text-white-800 dark:text-white hover:underline">
                                    {{ $pertemuanItem->judul }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
