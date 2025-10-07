@extends('layouts.app-siswa_perwakilan')

@section('title', 'Rekap Absensi')

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Header biru seperti Kelola Guru -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0 text-white d-flex align-items-center gap-2">
                    <i class="ti ti-clipboard-data fs-4"></i>
                    Rekap Absensi
                </h5>

                @if(!empty($kelasId) && ($periode ?? '') === 'bulan')
                <a href="{{ route('siswa_perwakilan.absensi.exportPdf', [
                    'kelas_id' => $kelasId,
                    'periode' => $periode,
                    'bulan' => $bulan,
                    ]) }}" class="btn btn-danger mb-3" target="_blank">
                    <i class="ti ti-file-type-pdf"></i> Export PDF
                </a>
                @endif
            </div>
        </div>

        <!-- Flash Message -->
        @if(session('success'))
            <div class="alert alert-success d-flex justify-content-between align-items-center">
                <div>
                    <i class="ti ti-check"></i> {{ session('success') }}
                </div>
                <a href="{{ route('siswa_perwakilan.absensi.index') }}" class="btn btn-sm btn-outline-light">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
            </div>
        @endif

        <!-- Filter -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" class="row g-2 align-items-center">
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
            </div>
        </div>

        <!-- Tabel Rekap -->
        @if(!empty($kelasId))
            @if($tanggalList->isEmpty())
                <div class="alert alert-info">Tidak ada data absensi untuk filter yang dipilih.</div>
            @else
                @if(($periode ?? '') === 'hari')
                    <form method="POST" action="{{ route('siswa_perwakilan.absensi.update_bulk') }}">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
                        <input type="hidden" name="tanggal" value="{{ $tanggal }}">

                        <div class="card shadow-sm">
                            <div class="card-body table-responsive">
                                <table class="table table-bordered align-middle text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th class="text-start">Nama Siswa</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($siswaList as $i => $siswa)
                                            @php $absen = $rekap[$siswa->id][$tanggal] ?? null; @endphp
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td class="text-start">{{ $siswa->nama }}</td>
                                                <td>
                                                    <select name="absensi[{{ $siswa->id }}][status]" class="form-select">
                                                        <option value="">-- pilih --</option>
                                                        <option value="hadir" {{ $absen?->status == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                                        <option value="izin" {{ $absen?->status == 'izin' ? 'selected' : '' }}>Izin</option>
                                                        <option value="sakit" {{ $absen?->status == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                                        <option value="alfa" {{ $absen?->status == 'alfa' ? 'selected' : '' }}>Alfa</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="absensi[{{ $siswa->id }}][keterangan]" class="form-control" value="{{ $absen?->keterangan }}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mt-3 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                @else
                    <div class="card shadow-sm">
                        <div class="card-body table-responsive">
                            <table class="table table-bordered align-middle text-center">
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
                                            <td>{{ $totalStatus[$siswa->id]['hadir'] ?? 0 }}</td>
                                            <td>{{ $totalStatus[$siswa->id]['sakit'] ?? 0 }}</td>
                                            <td>{{ $totalStatus[$siswa->id]['izin'] ?? 0 }}</td>
                                            <td>{{ $totalStatus[$siswa->id]['alfa'] ?? 0 }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            @endif
        @else
            <div class="alert alert-info">Silakan pilih kelas terlebih dahulu.</div>
        @endif
    </div>
</div>
@endsection