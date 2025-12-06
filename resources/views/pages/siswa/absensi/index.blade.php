@extends('layouts.app-siswa')

@section('title', 'Absensi Siswa')

@section('content')
<div class="card shadow-sm border-0 rounded-4 overflow-hidden">

    <div class="card-header bg-primary text-white rounded-top-4 py-3 d-flex justify-content-between align-items-center">
        <h4 class="mb-0 fw-bold d-flex align-items-center">
            <i class="bi bi-calendar-check me-2 fs-4"></i> Absensi Siswa
        </h4>
    </div>

    <div class="card-body bg-light">

        <div class="card border-0 shadow-sm rounded-3 p-3 mb-4">
            <form method="GET" class="row g-3 align-items-end">

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Pilih Kelas</label>
                    <select name="kelas_id" class="form-select shadow-sm" onchange="this.form.submit()">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ $selectedKelas == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold">Periode</label>
                    <select name="periode" class="form-select shadow-sm" onchange="this.form.submit()">
                        <option value="harian" {{ $periode == 'harian' ? 'selected' : '' }}>Harian</option>
                        <option value="bulanan" {{ $periode == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                    </select>
                </div>

                @if($periode == 'harian')
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control shadow-sm"
                           value="{{ $tanggal }}" onchange="this.form.submit()">
                </div>
                @endif

                @if($periode == 'bulanan')
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Bulan</label>
                    <select name="bulan" class="form-select shadow-sm" onchange="this.form.submit()">
                        @foreach(range(1,12) as $m)
                        <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold">Tahun</label>
                    <select name="tahun" class="form-select shadow-sm" onchange="this.form.submit()">
                        @foreach(range(date('Y')-2, date('Y')+1) as $y)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @endif

            </form>
        </div>

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>Nama Siswa</th>
                                <th>Tanggal</th>
                                <th>Hari</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($absensi as $a)
                            <tr>
                                <td class="fw-semibold">{{ $a->siswa->nama }}</td>
                                <td>{{ \Carbon\Carbon::parse($a->tanggal)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($a->tanggal)->translatedFormat('l') }}</td>
                                <td class="text-center">

                                    @if($a->status == 'hadir')
                                        <span class="badge bg-success px-3 py-2">Hadir</span>

                                    @elseif($a->status == 'izin')
                                        <span class="badge bg-warning text-dark px-3 py-2">Izin</span>

                                    @elseif($a->status == 'sakit')
                                        <span class="badge bg-info text-dark px-3 py-2">Sakit</span>

                                    @else
                                        <span class="badge bg-danger px-3 py-2">Alfa</span>
                                    @endif

                                </td>
                                <td>
                                    <textarea class="form-control form-control-sm shadow-sm rounded-3"
                                              rows="1" readonly>{{ $a->keterangan }}</textarea>
                                </td>
                            </tr>

                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Tidak ada data absensi untuk periode ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection