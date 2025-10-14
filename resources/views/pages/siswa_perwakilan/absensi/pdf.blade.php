<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Absensi Bulanan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        h2, p {
            margin: 0;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }
        th {
            background: #f0f0f0;
        }
        .text-start {
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Rekap Absensi Bulanan - {{ $kelas->nama_kelas }}</h2>
    <p>Periode: {{ date('F Y', strtotime($bulan)) }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th class="text-start">Nama Siswa</th>
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
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td class="text-start">{{ $siswa->nama }}</td>
                    @foreach($tanggalList as $tgl)
                        @php $absen = $rekap[$siswa->id][(string)$tgl] ?? null; @endphp
                        <td>
                            @if($absen)
                                @switch($absen->status)
                                    @case('hadir') H @break
                                    @case('izin') I @break
                                    @case('sakit') S @break
                                    @case('alfa') A @break
                                    @default {{ strtoupper(substr($absen->status,0,1)) }}
                                @endswitch
                            @else
                                -
                            @endif
                        </td>
                    @endforeach
                    <td>{{ $totalStatus[$siswa->id]['hadir'] ?? 0 }}</td>
                    <td>{{ $totalStatus[$siswa->id]['sakit'] ?? 0 }}</td>
                    <td>{{ $totalStatus[$siswa->id]['izin'] ?? 0 }}</td>
                    <td>{{ $totalStatus[$siswa->id]['alfa'] ?? 0 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>