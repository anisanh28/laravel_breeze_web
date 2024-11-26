<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Hasil Evaluasi') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="min-w-full bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 border border-gray-200 dark:border-gray-700 rounded-lg">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-white border-b">No</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-white border-b">Nama Siswa</th>
                                @foreach ($pertanyaan as $pertanyaanItem)
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-white border-b">{{ $loop->iteration }}</th>
                                @endforeach
                                <th class="px-6 py-3 text-left text-sm font-semibold text-white border-b">Nilai</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-white border-b">Lama Pengerjaan</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-white border-b">Waktu Pengumpulan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hasilEvaluasi as $index => $evaluasi)
                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <td class="px-6 py-3 text-sm text-white border-b">{{ $index + 1 }}</td>
                                    <td class="px-6 py-3 text-sm text-white border-b">{{ $evaluasi->user->name }}</td>

                                    @foreach ($pertanyaan as $pertanyaanItem)
                                        <td class="px-6 py-3 text-sm text-white border-b">
                                            {{ $evaluasi->jawaban[$loop->index + 1] ?? '-' }}
                                        </td>
                                    @endforeach

                                    <td class="px-6 py-3 text-sm text-white border-b">{{ $evaluasi->skor }}</td>
                                    <td class="px-6 py-3 text-sm text-white border-b">{{ $evaluasi->waktu_pengerjaan }}</td>
                                    <td class="px-6 py-3 text-sm text-white border-b">{{ $evaluasi->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <!-- Footer untuk menampilkan persentase jawaban benar -->
                        <tfoot>
                            <tr class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <td class="px-6 py-3 text-sm text-white border-b" colspan="2">Persentase</td>
                        
                                @foreach ($pertanyaan as $pertanyaanItem)
                                    <td class="px-6 py-3 text-sm text-white border-b text-center">
                                        @if (isset($pertanyaanItem->persentaseBenar))
                                            {{ number_format($pertanyaanItem->persentaseBenar, 2) }}%
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endforeach
                                
                                <td class="px-6 py-3 text-sm text-white border-b"></td>
                                <td class="px-6 py-3 text-sm text-white border-b"></td>
                                <td class="px-6 py-3 text-sm text-white border-b"></td>
                            </tr>
                        </tfoot>                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
