<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Jurnal Guru - {{ $guru->nama }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }
        h2, h3 {
            text-align: center;
            margin: 0;
        }
        .info {
            margin-top: 10px;
            margin-bottom: 20px;
        }
        .info p {
            margin: 4px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        th, td {
            border: 1px solid #555;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f1f1f1;
            font-weight: bold;
        }
        .tanggal {
            background-color: #e9ecef;
            font-weight: bold;
        }
        .footer {
            text-align: right;
            font-size: 11px;
            margin-top: 40px;
        }
    </style>
</head>
<body>

    <h2>REKAP JURNAL MENGAJAR</h2>
    <h3>Periode: {{ \Carbon\Carbon::parse($periode . '-01')->translatedFormat('F Y') }}</h3>

    <div class="info">
        <p><strong>Nama Guru:</strong> {{ $guru->nama }}</p>
        <p><strong>NIP:</strong> {{ $guru->nip ?? '-' }}</p>
        <p><strong>Dicetak pada:</strong> {{ now()->translatedFormat('d F Y, H:i') }}</p>
    </div>

    @forelse($jurnalBulanan as $tanggal => $dataJurnal)
        <table>
            <tr>
                <td colspan="6" class="tanggal">
                    {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
                </td>
            </tr>
            <tr>
                <th width="5%">No</th>
                <th>Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Jam</th>
                <th>Materi</th>
                <th>Keterangan</th>
            </tr>
            @foreach ($dataJurnal as $i => $j)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $j->kelas->nama_kelas ?? '-' }}</td>
                    <td>{{ $j->mataPelajaran->nama_mapel ?? '-' }}</td>
                    <td>{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</td>
                    <td>{{ $j->materi ?? '-' }}</td>
                    <td>{{ $j->keterangan ?? '-' }}</td>
                </tr>
            @endforeach
        </table>
    @empty
        <p style="text-align:center; margin-top:50px;">Tidak ada data jurnal untuk periode ini.</p>
    @endforelse

    <div class="footer">
        <p>Dicetak oleh sistem pada {{ now()->translatedFormat('d F Y') }}</p>
    </div>

</body>
</html>