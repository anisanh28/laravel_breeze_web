<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Anggota Kelas') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Daftar Anggota Kelas') }}</h3>

                    <!-- Tabel Anggota Kelas -->
                    <table class="min-w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b dark:border-gray-700">No</th>
                                <th class="px-4 py-2 border-b dark:border-gray-700">Nama</th>
                                <th class="px-4 py-2 border-b dark:border-gray-700">NIS</th>
                                <th class="px-4 py-2 border-b dark:border-gray-700">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswa as $index => $user)
                                <tr>
                                    <td class="px-4 py-2 border-b dark:border-gray-700">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border-b dark:border-gray-700">{{ $user->name }}</td>
                                    <td class="px-4 py-2 border-b dark:border-gray-700">{{ $user->nis }}</td>
                                    <td class="px-4 py-2 border-b dark:border-gray-700">{{ $user->email }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-2 text-center text-gray-500 dark:text-gray-400">
                                        {{ __('Tidak ada anggota kelas yang terdaftar') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
