@extends('layouts.app')

@section('title', 'Rekap Absensi')

@section('content')
<div class="container">
    <h3 class="mb-3">Rekap Absensi</h3>

    <!-- Filter -->
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

        <div class="col-md-2">
            <select name="periode" class="form-select" onchange="this.form.submit()">
                <option value="">-- Periode --</option>
                <option value="hari" {{ $periode == 'hari' ? 'selected' : '' }}>Harian</option>
                <option value="bulan" {{ $periode == 'bulan' ? 'selected' : '' }}>Bulanan</option>
            </select>
        </div>

        @if($periode == 'hari')
        <div class="col-md-3">
            <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}" onchange="this.form.submit()">
        </div>
        @elseif($periode == 'bulan')
        <div class="col-md-3">
            <input type="month" name="bulan" class="form-control" value="{{ $bulan }}" onchange="this.form.submit()">
        </div>
        @endif
    </form>

    @if($kelasId)
    <div class="mb-2">
        <a href="{{ route('admin.absensi.export', request()->all()) }}" class="btn btn-success">
            Export Excel
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2" class="text-start">Nama Siswa</th>
                    @foreach($tanggalList as $tgl)
                        <th>{{ \Carbon\Carbon::parse($tgl)->format('d') }}</th>
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
                    <td class="text-start">{{ $siswa->nama }}</td>
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
    </div>
    @endif
</div>
@endsection
