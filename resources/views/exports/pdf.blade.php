<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Jadwal Pelajaran</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h3 style="text-align: center;">Jadwal Pelajaran {{ $kelas->nama_kelas ?? '' }}</h3>

    @php
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

    <table>
        <thead>
            <tr>
                <th>Hari</th>
                @for($jam = 1; $jam <= 10; $jam++)
                    <th>
                        Jam {{ $jam }} <br>
                        <small>{{ $jamRanges[$jam] }}</small>
                    </th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat'] as $hari)
                <tr>
                    <td><strong>{{ $hari }}</strong></td>
                    @php $jam = 1; @endphp
                    @while($jam <= 10)
                        @if(isset($jadwalByHari[$hari][$jam]))
                            @php
                                $current = $jadwalByHari[$hari][$jam];
                                $colspan = 1;
                                for ($next = $jam + 1; $next <= 10; $next++) {
                                    if (
                                        isset($jadwalByHari[$hari][$next]) &&
                                        $jadwalByHari[$hari][$next]->mata_pelajaran_id == $current->mata_pelajaran_id &&
                                        $jadwalByHari[$hari][$next]->guru_id == $current->guru_id
                                    ) {
                                        $colspan++;
                                    } else {
                                        break;
                                    }
                                }
                            @endphp
                            <td colspan="{{ $colspan }}">
                                <strong>{{ $current->mataPelajaran->nama_mapel }}</strong><br>
                                <small>{{ $current->guru->nama ?? '-' }}</small>
                            </td>
                            @php $jam += $colspan; @endphp
                        @else
                            <td>-</td>
                            @php $jam++; @endphp
                        @endif
                    @endwhile
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>