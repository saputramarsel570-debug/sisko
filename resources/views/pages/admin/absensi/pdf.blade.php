<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Absensi PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
    </style>
</head>
<body>
    <h2>Rekap Absensi - {{ $kelas->nama_kelas }}</h2>
    <p>Periode: {{ $periode === 'hari' ? $tanggal : date('F Y', strtotime($bulan)) }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Hadir</th>
                <th>Sakit</th>
                <th>Izin</th>
                <th>Alfa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($siswaList as $i => $siswa)
                @php
                    $hadir = $absensi->where('siswa_id', $siswa->id)->where('status', 'hadir')->count();
                    $sakit = $absensi->where('siswa_id', $siswa->id)->where('status', 'sakit')->count();
                    $izin  = $absensi->where('siswa_id', $siswa->id)->where('status', 'izin')->count();
                    $alfa  = $absensi->where('siswa_id', $siswa->id)->where('status', 'alfa')->count();
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $siswa->nama }}</td>
                    <td>{{ $hadir }}</td>
                    <td>{{ $sakit }}</td>
                    <td>{{ $izin }}</td>
                    <td>{{ $alfa }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>