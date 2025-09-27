@extends('layouts.admin')

@section('content')
<div class="container">
    <h4>Rekap Absensi</h4>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3">
            <select name="kelas_id" class="form-select" onchange="this.form.submit()">
                <option value="">-- Pilih Kelas --</option>
                @foreach($kelasList as $kelas)
                    <option value="{{ $kelas->id }}" {{ $kelasId == $kelas->id ? 'selected' : '' }}>
                        {{ $kelas->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <input type="month" name="bulan" class="form-control" value="{{ $bulan }}" onchange="this.form.submit()">
        </div>
    </form>

    @if($kelasId && $bulan)
    <div class="mb-2">
        <a href="{{ route('admin.absensi.export', request()->all()) }}" class="btn btn-success">
            Export Excel
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered text-center">
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
                    <td class="text-start">{{ $siswa->nama }}</td>
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
    </div>
    @endif
</div>
@endsection
