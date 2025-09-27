<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            @foreach($tanggalList as $tgl)
                <th>{{ \Carbon\Carbon::parse($tgl)->format('d-m-Y') }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($siswaList as $i => $s)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $s->nama }}</td>
                @foreach($tanggalList as $tgl)
                    @php $a = $rekap[$s->id][(string)$tgl] ?? null; @endphp
                    <td>
                        @if($a)
                            {{ strtoupper(substr($a->status,0,1)) }}
                        @else
                            -
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
