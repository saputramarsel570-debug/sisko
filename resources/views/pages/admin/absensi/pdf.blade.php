<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Absensi Bulanan - {{ $kelas->nama_kelas }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        h2, p { margin: 0; padding: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: center; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .text-left { text-align: left; }
    </style>
</head>
<body>
    <h2>Rekap Absensi Bulanan</h2>
    <p><strong>Kelas:</strong> {{ $kelas->nama_kelas }}</p>
    <p><strong>Periode:</strong> {{ \Carbon\Carbon::parse($bulan)->translatedFormat('F Y') }}</p>

    @php
        // Buat daftar tanggal dari awal sampai akhir bulan
        $m = date('m', strtotime($bulan));
        $y = date('Y', strtotime($bulan));
        $start = \Carbon\Carbon::create($y, $m, 1);
        $end = $start->copy()->endOfMonth();
        $tanggalList = [];
        while ($start <= $end) {
            $tanggalList[] = $start->format('Y-m-d');
            $start->addDay();
        }
    @endphp

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th class="text-left">Nama Siswa</th>
                @foreach($tanggalList as $tgl)
                    <th>{{ \Carbon\Carbon::parse($tgl)->format('d') }}</th>
                @endforeach
                <th>H</th>
                <th>S</th>
                <th>I</th>
                <th>A</th>
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
                    <td class="text-left">{{ $siswa->nama }}</td>
                    @foreach($tanggalList as $tgl)
                        @php
                            $absen = $absensi->where('siswa_id', $siswa->id)->where('tanggal', $tgl)->first();
                        @endphp
                        <td>
                            @if($absen)
                                @if($absen->status === 'hadir')
                                    H
                                @elseif($absen->status === 'izin')
                                    I
                                @elseif($absen->status === 'sakit')
                                    S
                                @elseif($absen->status === 'alfa')
                                    A
                                @else
                                    {{ strtoupper(substr($absen->status,0,1)) }}
                                @endif
                            @else
                                -
                            @endif
                        </td>
                    @endforeach
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