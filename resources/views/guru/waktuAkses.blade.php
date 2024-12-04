<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white dark:text-white leading-tight">
            Waktu Akses - {{ $submateri->judulSubMateri }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="min-w-full bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b dark:border-gray-700">Nama Pengguna</th>
                                <th class="px-4 py-2 border-b dark:border-gray-700">Durasi (Total)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($waktuAksesList as $akses)
                                <tr>
                                    <td class="px-4 py-2 text-sm border-b dark:border-gray-700">
                                        {{ $akses->user->name ?? 'Anonim' }}
                                    </td>
                                    <td class="px-4 py-2 text-sm border-b dark:border-gray-700">{{ $akses->total_durasi }} detik</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center py-4">Belum ada data waktu akses.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
