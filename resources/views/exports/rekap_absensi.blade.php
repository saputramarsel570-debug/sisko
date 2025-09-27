<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            @foreach($tanggalList as $tgl)
                <th>{{ \Carbon\Carbon::parse($tgl)->format('d-m') }}</th>
            @endforeach
            <th>H</th>
            <th>I</th>
            <th>S</th>
            <th>A</th>
        </tr>
    </thead>
    <tbody>
        @foreach($siswaList as $i => $siswa)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $siswa->nama }}</td>
            @foreach($tanggalList as $tgl)
                @php $status = $rekap[$siswa->id][$tgl] ?? null; @endphp
                <td>
                    @if($status == 'hadir') H
                    @elseif($status == 'izin') I
                    @elseif($status == 'sakit') S
                    @elseif($status == 'alfa') A
                    @else -
                    @endif
                </td>
            @endforeach
            <td>{{ $totals[$siswa->id]['H'] ?? 0 }}</td>
            <td>{{ $totals[$siswa->id]['I'] ?? 0 }}</td>
            <td>{{ $totals[$siswa->id]['S'] ?? 0 }}</td>
            <td>{{ $totals[$siswa->id]['A'] ?? 0 }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
