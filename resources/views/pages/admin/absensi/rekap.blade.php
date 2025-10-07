@extends('layouts.app')

@section('title', 'Rekap Absensi')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
            <h4 class="mb-0"><i class="ti ti-clipboard-text"></i> Rekap Absensi</h4>
        </div>

        <div class="card-body">
            <!-- Filter -->
            <form method="GET" class="row g-2 mb-4 align-items-center">
                <div class="col-md-3">
                    <select name="kelas_id" class="form-select shadow-sm" onchange="this.form.submit()">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ (string)($kelasId ?? '') === (string)$kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="periode" class="form-select shadow-sm" onchange="this.form.submit()">
                        <option value="">-- Periode --</option>
                        <option value="hari" {{ ($periode ?? '') === 'hari' ? 'selected' : '' }}>Harian</option>
                        <option value="bulan" {{ ($periode ?? '') === 'bulan' ? 'selected' : '' }}>Bulanan</option>
                    </select>
                </div>

                @if(($periode ?? '') === 'hari')
                    <div class="col-md-3">
                        <input type="date" name="tanggal" class="form-control shadow-sm" value="{{ $tanggal ?? '' }}" onchange="this.form.submit()">
                    </div>
                @elseif(($periode ?? '') === 'bulan')
                    <div class="col-md-3">
                        <input type="month" name="bulan" class="form-control shadow-sm" value="{{ $bulan ?? '' }}" onchange="this.form.submit()">
                    </div>
                @endif
            </form>

            @if(!empty($kelasId))
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                <h6 class="mb-2 mb-md-0">
                    <strong>Kelas:</strong> {{ optional($kelasList->firstWhere('id', $kelasId))->nama_kelas ?? '-' }}
                </h6>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <!-- Tombol Export Excel -->
                    <a href="{{ route('admin.absensi.export', [
                        'kelas_id' => $kelasId,
                        'periode' => $periode,
                        'tanggal' => $tanggal,
                        'bulan' => $bulan
                    ]) }}" 
                    class="btn btn-success btn-sm shadow-sm d-flex align-items-center gap-1">
                        <i class="ti ti-file-spreadsheet"></i> 
                        <span>Excel</span>
                    </a>

                    <!-- Tombol Export PDF (muncul hanya saat bulanan) -->
                    @if(($periode ?? '') === 'bulan')
                    <a href="{{ route('admin.absensi.exportPdf', [
                        'kelas_id' => $kelasId,
                        'periode' => $periode,
                        'bulan' => $bulan
                    ]) }}" 
                    class="btn btn-danger btn-sm shadow-sm d-flex align-items-center gap-1" target="_blank">
                        <i class="ti ti-file-type-pdf"></i> 
                        <span>PDF</span>
                    </a>
                    @endif
                </div>
            </div>
                @if($tanggalList->isEmpty())
                    <div class="alert alert-warning text-center rounded-3 shadow-sm">
                        <i class="ti ti-alert-circle"></i> Tidak ada data absensi untuk filter yang dipilih.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle text-center shadow-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th class="text-start">Nama Siswa</th>
                                    @foreach($tanggalList as $tgl)
                                        <th>{{ \Carbon\Carbon::parse($tgl)->format('d-m') }}</th>
                                    @endforeach
                                    <th>H</th>
                                    <th>S</th>
                                    <th>I</th>
                                    <th>A</th>
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
                                                    @if($absen->status === 'hadir')
                                                        <span class="badge bg-success">H</span>
                                                    @elseif($absen->status === 'izin')
                                                        <span class="badge bg-warning text-dark">I</span>
                                                    @elseif($absen->status === 'sakit')
                                                        <span class="badge bg-info text-dark">S</span>
                                                    @elseif($absen->status === 'alfa')
                                                        <span class="badge bg-danger">A</span>
                                                    @else
                                                        {{ strtoupper(substr($absen->status,0,1)) }}
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        @endforeach
                                        <td><span class="badge bg-success">{{ $totalStatus[$siswa->id]['hadir'] ?? 0 }}</span></td>
                                        <td><span class="badge bg-info text-dark">{{ $totalStatus[$siswa->id]['sakit'] ?? 0 }}</span></td>
                                        <td><span class="badge bg-warning text-dark">{{ $totalStatus[$siswa->id]['izin'] ?? 0 }}</span></td>
                                        <td><span class="badge bg-danger">{{ $totalStatus[$siswa->id]['alfa'] ?? 0 }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @else
                <div class="alert alert-info text-center rounded-3 shadow-sm">
                    <i class="ti ti-info-circle"></i> Silakan pilih kelas terlebih dahulu.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
