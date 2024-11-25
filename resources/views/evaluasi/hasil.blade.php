<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __($evaluasi->judul_evaluasi) }}
        </h2>
    </x-slot>

    <div class="container py-6">
        <h2 class="text-2xl font-semibold">Hasil Evaluasi</h2>
        <p class="mt-4"><strong>Evaluasi:</strong> {{ $hasilEvaluasi->evaluasi->judul_evaluasi }}</p>
        <p><strong>Skor Anda:</strong> {{ $hasilEvaluasi->skor }}</p>
        <p><strong>Deskripsi:</strong> {{ $hasilEvaluasi->evaluasi->deskripsi_evaluasi }}</p>

        <!-- Back to Evaluation List Button -->
        <a href="{{ route('evaluasi.index') }}" class="mt-6 inline-block bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
            Kembali ke Daftar Evaluasi
        </a>
    </div>
</x-app-layout>
