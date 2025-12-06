@extends('layouts.app')

@section('title', 'Rekap Absensi')

@section('content')

<div class="container">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
            <h4 class="mb-0"><i class="ti ti-clipboard-text"></i> Rekap Absensi</h4>
        </div>

        <div class="card-body">

            <!-- FILTER -->
            <form method="GET" class="row g-2 mb-4 align-items-end mt-3">

                <!-- KELAS -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Kelas</label>
                    <select name="kelas_id" class="form-select shadow-sm">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" 
                                {{ (string)($kelasId ?? '') === (string)$kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- PERIODE -->
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Periode</label>
                    <select name="periode" id="periode" class="form-select shadow-sm">
                        <option value="">-- Periode --</option>
                        <option value="hari" {{ ($periode ?? '') === 'hari' ? 'selected' : '' }}>Harian</option>
                        <option value="bulan" {{ ($periode ?? '') === 'bulan' ? 'selected' : '' }}>Bulanan</option>
                    </select>
                </div>

                <!-- TANGGAL - MUNCUL OTOMATIS -->
                <div class="col-md-3" id="tanggalWrapper" style="display: none;">
                    <label class="form-label fw-semibold">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control shadow-sm"
                           value="{{ $tanggal ?? '' }}">
                </div>

                <!-- BULAN - MUNCUL OTOMATIS -->
                <div class="col-md-3" id="bulanWrapper" style="display: none;">
                    <label class="form-label fw-semibold">Bulan</label>
                    <input type="month" name="bulan" class="form-control shadow-sm"
                           value="{{ $bulan ?? '' }}">
                </div>

                <!-- TOMBOL TAMPILKAN -->
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary shadow-sm w-100">
                        <i class="ti ti-search"></i> Tampilkan
                    </button>
                </div>
            </form>

            <!-- SCRIPT UNTUK MEMUNCULKAN INPUT OTOMATIS -->
            <script>
                function updatePeriodeFields() {
                    let periode = document.getElementById("periode").value;

                    document.getElementById("tanggalWrapper").style.display =
                        periode === "hari" ? "block" : "none";

                    document.getElementById("bulanWrapper").style.display =
                        periode === "bulan" ? "block" : "none";
                }

                document.getElementById("periode").addEventListener("change", updatePeriodeFields);

                // Jalankan saat halaman pertama kali dibuka (agar langsung muncul)
                updatePeriodeFields();
            </script>

            <!-- DATA TABEL -->
            @if(!empty($kelasId))

            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                <h6 class="mb-0">
                    <strong>Kelas:</strong> {{ optional($kelasList->firstWhere('id', $kelasId))->nama_kelas ?? '-' }}
                </h6>

                <div class="d-flex flex-wrap align-items-center gap-2">

                    <!-- PDF HANYA MUNCUL JIKA PERIODE = BULAN & BULAN DIPILIH -->
                    @if(($periode ?? '') === 'bulan' && !empty($bulan))
                        <a href="{{ route('admin.absensi.exportPdf', [
                            'kelas_id' => $kelasId,
                            'periode'  => $periode,
                            'bulan'    => $bulan
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
                                            @switch($absen->status)
                                                @case('hadir') H @break
                                                @case('izin') I @break
                                                @case('sakit') S @break
                                                @case('alfa') A @break
                                                @default {{ strtoupper(substr($absen->status, 0, 1)) }}
                                            @endswitch
                                        @else
                                            <span class="text-muted">-</span>
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