@extends('layouts.app-orangtua')

@section('title', 'Absensi Anak')

@section('content')
<div class="card shadow-sm border-0 rounded-4 overflow-hidden">

    <div class="card-header bg-primary bg-gradient text-white py-3 d-flex justify-content-between align-items-center">
        <h4 class="mb-0 fw-bold">
            <i class="ti ti-clipboard-text me-2"></i> Absensi Anak — {{ $siswa->nama }}
        </h4>
    </div>

    <div class="card-body bg-light-subtle">

        <div class="filter-box p-3 rounded-4 shadow-sm mb-4 border">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Pilih Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control rounded-3"
                        value="{{ request('tanggal') }}">
                </div>

                <div class="col-md-8 d-flex align-items-end gap-2">
                    <button class="btn btn-primary rounded-pill px-4" type="submit">
                        <i class="ti ti-filter me-1"></i> Filter
                    </button>
                    <a href="{{ route('orangtua.absensi.index') }}" class="btn btn-secondary rounded-pill px-4">
                        <i class="ti ti-refresh me-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0 dataTable">
                        <thead class="table-primary text-dark">
                            <tr class="text-center">
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
                                    <td class="fw-semibold text-center">{{ $siswa->nama }}</td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($a->tanggal)->format('d-m-Y') }}
                                    </td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($a->tanggal)->translatedFormat('l') }}
                                    </td>
                                    <td class="text-center">
                                        @switch($a->status)
                                            @case('hadir')
                                                <span class="badge status-badge hadir">Hadir</span>
                                                @break
                                            @case('izin')
                                                <span class="badge status-badge izin">Izin</span>
                                                @break
                                            @case('sakit')
                                                <span class="badge status-badge sakit">Sakit</span>
                                                @break
                                            @default
                                                <span class="badge status-badge alfa">Alfa</span>
                                        @endswitch
                                    </td>
                                    <td class="text-center">{{ $a->keterangan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">
                                        <i class="ti ti-info-circle me-1"></i> Tidak ada data absensi ditemukan
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

@push('styles')
<style>
    .filter-box {
        background: #ffffff;
    }

    .table-hover tbody tr:hover {
        background-color: #f1f7ff !important;
    }

    .status-badge {
        font-size: 13px;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600 !important;
    }

    .status-badge.hadir {
        background: #d1f7d6;
        color: #2e8b57;
    }

    .status-badge.izin {
        background: #fff3cd;
        color: #856404;
    }

    .status-badge.sakit {
        background: #d4edfc;
        color: #0b70b5;
    }

    .status-badge.alfa {
        background: #f9d6d6;
        color: #b30000;
    }
</style>
@endpush