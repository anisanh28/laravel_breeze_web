<div>
    <h3 class="text-2xl font-bold mb-4">{{ $evaluasi->judul_evaluasi }}</h3>
    <p class="text-gray-700 dark:text-gray-300 mb-6" id="deskripsi">
        <span class="font-semibold">Deskripsi:</span>
        {{ $evaluasi->deskripsi_evaluasi }}
    </p>
    <p class="text-gray-700 dark:text-gray-300 mb-4" id="waktu-mulai">
        <span class="font-semibold">Waktu Mulai:</span>
        {{ \Carbon\Carbon::parse($evaluasi->start_time)->format('d M Y H:i') }}
    </p>
    <p class="text-gray-700 dark:text-gray-300 mb-4" id="waktu-selesai">
        <span class="font-semibold">Waktu Selesai:</span>
        {{ \Carbon\Carbon::parse($evaluasi->end_time)->format('d M Y H:i') }}
    </p>
    @php
        list($jam, $menit, $detik) = explode(":", $evaluasi->durasi);
        $durasi_in_minutes = (intval($jam) * 60) + intval($menit) + (intval($detik) / 60);
    @endphp
    <p id="durasi" class="font-semibold mb-4"><strong class="font-semibold">Durasi:</strong> {{ round($durasi_in_minutes) }} menit</p>
</div>
