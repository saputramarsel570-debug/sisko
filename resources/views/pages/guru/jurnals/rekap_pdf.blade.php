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

    @php
        // JAM RANGES DIPAKAI UNTUK PDF
        $jamRanges = [
            1 => '07:00 - 07:45',
            2 => '07:45 - 08:30',
            3 => '08:30 - 09:15',
            4 => '09:30 - 10:15',
            5 => '10:15 - 11:00',
            6 => '11:00 - 11:45',
            7 => '12:30 - 13:15',
            8 => '13:15 - 14:00',
            9 => '14:00 - 14:45',
            10 => '14:45 - 15:30',
        ];
    @endphp

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
                <th>Catatan</th>
            </tr>

            @foreach ($dataJurnal as $i => $j)
                <tr>
                    <td>{{ $i + 1 }}</td>

                    <td>{{ $j->kelas->nama_kelas ?? '-' }}</td>

                    <td>{{ $j->mataPelajaran->nama_mapel ?? '-' }}</td>

                    {{-- JAM FIX (PAKAI jamRanges) --}}
                    <td>
                        @if ($j->jam_mulai && $j->jam_selesai)
                            @php
                                $mulai = $jamRanges[$j->jam_mulai] ?? null;
                                $selesai = $jamRanges[$j->jam_selesai] ?? null;
                    
                                // Ambil jam awal dari range mulai
                                if ($mulai) {
                                    $mulaiJam = explode(' - ', $mulai)[0];
                                }
                    
                                // Ambil jam akhir dari range selesai
                                if ($selesai) {
                                    $selesaiJam = explode(' - ', $selesai)[1];
                                }
                            @endphp
                    
                            {{ $mulaiJam ?? '-' }} - {{ $selesaiJam ?? '-' }}
                    
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $j->materi ?? '-' }}</td>

                    <td>{{ $j->catatan ?? '-' }}</td>
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