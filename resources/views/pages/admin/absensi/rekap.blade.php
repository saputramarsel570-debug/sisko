@extends('layouts.app')

@section('title', 'Rekap Absensi')

@section('content')
<div class="container">
    <h3 class="mb-3">Rekap Absensi</h3>

    <form method="GET" class="row g-2 mb-3 align-items-center">
        <div class="col-md-3">
            <select name="kelas_id" class="form-select" onchange="this.form.submit()">
                <option value="">-- Pilih Kelas --</option>
                @foreach($kelasList as $kelas)
                    <option value="{{ $kelas->id }}" {{ (string)($kelasId ?? '') === (string)$kelas->id ? 'selected' : '' }}>
                        {{ $kelas->nama_kelas }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <select name="periode" class="form-select" onchange="this.form.submit()">
                <option value="">-- Periode --</option>
                <option value="hari" {{ ($periode ?? '') === 'hari' ? 'selected' : '' }}>Harian</option>
                <option value="bulan" {{ ($periode ?? '') === 'bulan' ? 'selected' : '' }}>Bulanan</option>
            </select>
        </div>

        @if(($periode ?? '') === 'hari')
            <div class="col-md-3">
                <input type="date" name="tanggal" class="form-control" value="{{ $tanggal ?? '' }}" onchange="this.form.submit()">
            </div>
        @elseif(($periode ?? '') === 'bulan')
            <div class="col-md-3">
                <input type="month" name="bulan" class="form-control" value="{{ $bulan ?? '' }}" onchange="this.form.submit()">
            </div>
        @endif
    </form>

    @if(!empty($kelasId))
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div>
                <strong>Kelas:</strong> {{ optional($kelasList->firstWhere('id', $kelasId))->nama_kelas ?? '-' }}
            </div>
            <div>
                <a href="{{ route('admin.absensi.export', ['kelas_id'=>$kelasId, 'periode'=>$periode, 'tanggal'=>$tanggal, 'bulan'=>$bulan]) }}" class="btn btn-success">
                    <i class="ti ti-file-export"></i> Export Excel
                </a>
            </div>
        </div>

        @if($tanggalList->isEmpty())
            <div class="alert alert-info">Tidak ada data absensi untuk filter yang dipilih.</div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th class="text-start">Nama Siswa</th>
                            @foreach($tanggalList as $tgl)
                                <th>{{ \Carbon\Carbon::parse($tgl)->format('d-m') }}</th>
                            @endforeach
                            <th>Total H</th>
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
                                            @if($absen->status === 'hadir') H
                                            @elseif($absen->status === 'izin') I
                                            @elseif($absen->status === 'sakit') S
                                            @elseif($absen->status === 'alfa') A
                                            @else {{ strtoupper(substr($absen->status,0,1)) }}
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endforeach
                                <td>{{ $hadirCounts[$siswa->id] ?? 0 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @else
        <div class="alert alert-info">Silakan pilih kelas terlebih dahulu.</div>
    @endif
</div>
@endsection
