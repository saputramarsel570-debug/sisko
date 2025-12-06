<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Jurnal Bulanan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0; /* fix border gap */
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #000;
            border-right-width: 1px !important;  /* ← FIX garis kanan hilang */
            padding: 4px;
            vertical-align: top;
            word-wrap: break-word;
        }

        th { background-color: #f0f0f0; text-align: center; }

        .col-jam {
            width: 14%;
            white-space: nowrap;
            text-align: center;
        }

        .col-mapel { width: 24%; }
        .col-guru { width: 18%; }
        .col-materi { width: 24%; }
        .col-catatan { width: 20%; }

        /* row kosong untuk rowspan */
        .empty-row td {
            border: 0 !important;
            padding: 0 !important;
            height: 0 !important;
        }

        h3, h4 { text-align: center; margin-bottom: 5px; }
    </style>
</head>

<body>

<h3>Rekap Jurnal Bulan {{ \Carbon\Carbon::parse($periode.'-01')->translatedFormat('F Y') }}</h3>
<p style="text-align:center;"><strong>Kelas: {{ $kelas->nama_kelas ?? '-' }}</strong></p>
<hr>

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

@foreach($jadwalBulanan as $tanggal => $jadwalHarian)

    <h4>{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}</h4>

    @php
        $groups = [];
        $temp = null;

        foreach ($jadwalHarian as $item) {
            if (!$temp) {
                $temp = [
                    "start" => $item->jam_mulai,
                    "end" => $item->jam_selesai,
                    "mapel" => $item->mata_pelajaran_id,
                    "guru" => $item->guru_id,
                    "items" => [$item],
                ];
                continue;
            }

            $isConsecutive = ($item->jam_mulai == $temp["end"] + 1);
            $isSameMapel = ($item->mata_pelajaran_id == $temp["mapel"]);
            $isSameGuru = ($item->guru_id == $temp["guru"]);

            if ($isConsecutive && $isSameMapel && $isSameGuru) {
                $temp["end"] = $item->jam_selesai;
                $temp["items"][] = $item;
            } else {
                $groups[] = $temp;
                $temp = [
                    "start" => $item->jam_mulai,
                    "end" => $item->jam_selesai,
                    "mapel" => $item->mata_pelajaran_id,
                    "guru" => $item->guru_id,
                    "items" => [$item],
                ];
            }
        }
        if ($temp) $groups[] = $temp;
    @endphp

    <table>
        <thead>
            <tr>
                <th class="col-jam">Jam</th>
                <th class="col-mapel">Mata Pelajaran</th>
                <th class="col-guru">Guru</th>
                <th class="col-materi">Materi</th>
                <th class="col-catatan">Catatan</th>
            </tr>
        </thead>

        <tbody>
            @foreach($groups as $group)
                @php
                    $start = $jamRanges[$group["start"]] ?? '';
                    $end   = $jamRanges[$group["end"]] ?? '';
                    $jamFinal = explode(" - ", $start)[0] . " - " . explode(" - ", $end)[1];

                    $first = $group["items"][0];
                    $rowspan = count($group["items"]);

                    $jurnalForDay = $jurnalBulanan[$tanggal] ?? collect();
                    $jurnal = $jurnalForDay->firstWhere("mata_pelajaran_id", $group["mapel"]);
                @endphp

                <tr>
                    <td class="col-jam" rowspan="{{ $rowspan }}">{{ $jamFinal }}</td>
                    <td rowspan="{{ $rowspan }}">{{ $first->mataPelajaran->nama_mapel ?? "-" }}</td>
                    <td rowspan="{{ $rowspan }}">{{ $first->guru->nama ?? "-" }}</td>
                    <td rowspan="{{ $rowspan }}">{{ $jurnal->materi ?? "-" }}</td>
                    <td rowspan="{{ $rowspan }}">{{ $jurnal->catatan ?? "-" }}</td>
                </tr>

                @for($i = 1; $i < $rowspan; $i++)
                    <tr class="empty-row"><td></td></tr>
                @endfor

            @endforeach
        </tbody>
    </table>

@endforeach

</body>
</html>