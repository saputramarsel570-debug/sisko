@extends('layouts.app-siswa_perwakilan')

@section('title', 'Rekap Absensi')

@section('content')
<div class="row">
    <div class="col-md-12">

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

        @if (session('success'))
        <div id="success" class="alert alert-solid-success d-flex align-items-center" role="alert">
            <span class="alert-icon rounded"><i class="ti ti-check"></i></span>
            {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-solid-danger d-flex align-items-center" role="alert">
            <span class="alert-icon rounded"><i class="ti ti-alert-triangle"></i></span>
            <div>
                <strong>Terjadi kesalahan:</strong>
                <ul class="mt-1 mb-0">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" class="row g-2 align-items-center">

                    <div class="col-md-3">
                        <input type="text" class="form-control bg-light"
                            value="{{ $siswaList->first()->kelas->nama_kelas ?? '-' }}" readonly>
                        <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
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
                            <input type="date" name="tanggal" class="form-control"
                                value="{{ request('tanggal', $tanggal ?? '') }}"
                                onchange="this.form.submit()">
                        </div>
                    @elseif(($periode ?? '') === 'bulan')
                        <div class="col-md-3">
                            <input type="month" name="bulan" class="form-control"
                                value="{{ request('bulan', $bulan ?? '') }}"
                                onchange="this.form.submit()">
                        </div>
                    @endif
                </form>
            </div>
        </div>

        {{-- ============================= --}}
        {{--   VALIDASI KELAS + DATA      --}}
        {{-- ============================= --}}
        @if(!empty($kelasId))
            @if($siswaList->isEmpty())
                <div class="alert alert-warning">Tidak ada data siswa pada kelas ini.</div>

            @elseif(empty($tanggalList))
                <div class="alert alert-info">Tidak ada data absensi untuk filter ini.</div>

            @else

                {{-- ====================================================== --}}
                {{--                   MODE HARIAN (INPUT)                 --}}
                {{-- ====================================================== --}}
                @if(($periode ?? '') === 'hari')

                <form method="POST" action="{{ route('siswa_perwakilan.absensi.update_bulk') }}">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
                    <input type="hidden" name="tanggal" value="{{ $tanggal }}">

                    <div class="card shadow-sm">
                        <div class="card-body table-responsive">

                            <button type="button" id="hadirSemua" class="btn btn-success mb-3">
                                <i class="ti ti-user-check"></i> Hadir Semua
                            </button>

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
                                        @php 
                                            $absen = $rekap[$siswa->id][$tanggal] ?? null;

                                            $selectedStatus = old("absensi.$siswa->id.status", $absen->status ?? '');
                                            $selectedKet = old("absensi.$siswa->id.keterangan", $absen->keterangan ?? '');
                                        @endphp

                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td class="text-start">{{ $siswa->nama }}</td>

                                            <td>
                                                <select 
                                                    name="absensi[{{ $siswa->id }}][status]" 
                                                    class="form-select status-select">
                                                    <option value="">-- Pilih --</option>
                                                    <option value="hadir" {{ $selectedStatus == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                                    <option value="izin" {{ $selectedStatus == 'izin' ? 'selected' : '' }}>Izin</option>
                                                    <option value="sakit" {{ $selectedStatus == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                                    <option value="alfa" {{ $selectedStatus == 'alfa' ? 'selected' : '' }}>Alfa</option>
                                                </select>
                                            </td>

                                            <td>
                                                <input type="text"
                                                    name="absensi[{{ $siswa->id }}][keterangan]"
                                                    class="form-control"
                                                    value="{{ $selectedKet }}">
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

                {{-- ====================================================== --}}
                {{--                   MODE BULANAN (REKAP)                --}}
                {{-- ====================================================== --}}
                @else

<div class="card shadow-sm">
    <div class="card-body table-responsive">

        <table class="table table-bordered text-center align-middle">
            <thead class="table-light align-middle">
                <tr>
                    <th rowspan="2" style="width: 50px;">No</th>
                    <th rowspan="2" class="text-start" style="width: 200px;">Nama Siswa</th>

                    @foreach($tanggalList as $tgl)
                        <th style="width: 45px;">
                            {{ \Carbon\Carbon::parse($tgl)->format('d') }}
                        </th>
                    @endforeach

                    <th rowspan="2" style="width: 45px;">H</th>
                    <th rowspan="2" style="width: 45px;">S</th>
                    <th rowspan="2" style="width: 45px;">I</th>
                    <th rowspan="2" style="width: 45px;">A</th>
                </tr>

                <tr></tr>
            </thead>

            <tbody>
                @foreach($siswaList as $i => $siswa)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td class="text-start fw-semibold">{{ $siswa->nama }}</td>

                    @foreach($tanggalList as $tgl)
                        @php 
                            $abs = $rekap[$siswa->id][$tgl] ?? null; 
                        @endphp

                        <td>
                            @if($abs)
                                {{-- tanpa warna --}}
                                <span class="fw-bold">
                                    {{ strtoupper(substr($abs->status, 0, 1)) }}
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    @endforeach

                    {{-- TOTAL (tanpa warna) --}}
                    <td class="fw-bold">{{ $totalStatus[$siswa->id]['hadir'] ?? 0 }}</td>
                    <td class="fw-bold">{{ $totalStatus[$siswa->id]['sakit'] ?? 0 }}</td>
                    <td class="fw-bold">{{ $totalStatus[$siswa->id]['izin'] ?? 0 }}</td>
                    <td class="fw-bold">{{ $totalStatus[$siswa->id]['alfa'] ?? 0 }}</td>

                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

                @endif {{-- end periode bulan --}}
            @endif
        @else
            <div class="alert alert-info">Silakan pilih kelas terlebih dahulu.</div>
        @endif

    </div>
</div>
@endsection

@push('scripts')
<script>

setTimeout(() => {
    const a = document.querySelectorAll('#success, #error');
    a.forEach(el => {
        el.style.transition = "0.5s";
        el.style.opacity = "0";
        setTimeout(() => el.remove(), 500);
    });
}, 3000);

document.getElementById('hadirSemua')?.addEventListener('click', () => {
    document.querySelectorAll('.status-select').forEach(select => {
        select.value = 'hadir';
    });
});

</script>
@endpush