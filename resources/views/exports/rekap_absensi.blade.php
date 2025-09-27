<table>
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Nama Siswa</th>
            @foreach($tanggalList as $tgl)
                <th>{{ \Carbon\Carbon::parse($tgl)->format('d-m') }}</th>
            @endforeach
            <th colspan="4">Total</th>
        </tr>
        <tr>
            <th>H</th>
            <th>S</th>
            <th>I</th>
            <th>A</th>
        </tr>
    </thead>
    <tbody>
        @foreach($siswaList as $i => $siswa)
        @php
            $totalH = $totalS = $totalI = $totalA = 0;
        @endphp
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $siswa->nama }}</td>
            @foreach($tanggalList as $tgl)
                @php $absen = $rekap[$siswa->id][$tgl] ?? null; @endphp
                <td>
                    @if($absen)
                        @if($absen->status == 'hadir')
                            @php $totalH++; @endphp H
                        @elseif($absen->status == 'izin')
                            @php $totalI++; @endphp I
                        @elseif($absen->status == 'sakit')
                            @php $totalS++; @endphp S
                        @elseif($absen->status == 'alfa')
                            @php $totalA++; @endphp A
                        @endif
                    @else
                        -
                    @endif
                </td>
            @endforeach
            <td>{{ $totalH }}</td>
            <td>{{ $totalS }}</td>
            <td>{{ $totalI }}</td>
            <td>{{ $totalA }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
