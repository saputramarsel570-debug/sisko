<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Jurnal - {{ $tanggal }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; vertical-align: top; }
        th { background-color: #f0f0f0; }
        h3, p { margin: 0; }
    </style>
</head>
<body>
    <h3>Rekap Jurnal Kelas {{ $kelasList->where('id', $kelasId)->first()->nama_kelas ?? '-' }}</h3>
    <p>Tanggal: {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Jam</th>
                <th>Mata Pelajaran</th>
                <th>Guru</th>
                <th>Materi</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jadwalGabung as $jadwal)
                @php
                    $jurnal = $jurnalHariIni[$jadwal->jam_mulai.'-'.$jadwal->jam_selesai] ?? null;
                    $jamTampil = $jadwal->jam_mulai . ' - ' . $jadwal->jam_selesai;
                @endphp
                <tr>
                    <td>{{ $jamTampil }}</td>
                    <td>{{ $jadwal->mataPelajaran->nama_mapel ?? '-' }}</td>
                    <td>{{ $jadwal->guru->nama ?? '-' }}</td>
                    <td>{{ $jurnal->materi ?? '-' }}</td>
                    <td>{{ $jurnal->catatan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align:center;">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>