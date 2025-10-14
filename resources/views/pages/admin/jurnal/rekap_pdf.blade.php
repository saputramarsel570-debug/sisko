<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Jurnal Bulanan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; vertical-align: top; }
        th { background-color: #f0f0f0; }
        h3, h4 { text-align: center; margin-bottom: 5px; }
        .title { margin-bottom: 20px; text-align: center; }
    </style>
</head>
<body>
    <h3>Rekap Jurnal Bulan {{ \Carbon\Carbon::parse($periode.'-01')->translatedFormat('F Y') }}</h3>
    <p class="text-center"><strong>Kelas: {{ $kelas->nama_kelas ?? '-' }}</strong></p>
    <hr>

    @foreach($jadwalBulanan as $tanggal => $jadwalHarian)
        <h4>{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}</h4>
        <table>
            <thead>
                <tr>
                    <th width="25%">Mata Pelajaran</th>
                    <th width="20%">Guru</th>
                    <th width="25%">Materi</th>
                    <th width="30%">Catatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jadwalHarian as $jadwal)
                    @php
                        $jurnal = isset($jurnalBulanan[$tanggal])
                            ? $jurnalBulanan[$tanggal]->firstWhere('mata_pelajaran_id', $jadwal->mata_pelajaran_id)
                            : null;
                    @endphp
                    <tr>
                        <td>{{ $jadwal->mataPelajaran->nama_mapel ?? '-' }}</td>
                        <td>{{ $jadwal->guru->nama ?? '-' }}</td>
                        <td>{{ $jurnal->materi ?? '-' }}</td>
                        <td>{{ $jurnal->catatan ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>
</html>