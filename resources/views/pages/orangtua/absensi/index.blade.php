@extends('layouts.app-orangtua')

@section('title', 'Absensi Anak')

@section('content')
<div class="card shadow-sm border-0 rounded-4 overflow-hidden">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0 fw-bold">
            <i class="ti ti-clipboard-text me-2"></i> Absensi Anak - {{ $siswa->nama }}
        </h4>
    </div>

    <div class="card-body bg-light-subtle">
        {{-- 🔍 Filter Tanggal --}}
        <form method="GET" class="row g-3 mb-4 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ request('tanggal') }}">
            </div>

            <div class="col-md-8 d-flex align-items-end gap-2">
                <button class="btn btn-primary" type="submit">
                    <i class="ti ti-filter me-1"></i> Filter
                </button>
                <a href="{{ route('orangtua.absensi.index') }}" class="btn btn-secondary">
                    <i class="ti ti-refresh me-1"></i> Tampilkan Semua
                </a>
            </div>
        </form>

        {{-- 📋 Tabel Absensi --}}
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle dataTable">
                        <thead class="table-light">
                            <tr class="text-center align-middle">
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
                                    <td class="fw-semibold">{{ $siswa->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($a->tanggal)->format('d-m-Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($a->tanggal)->translatedFormat('l') }}</td>
                                    <td>
                                        @switch($a->status)
                                            @case('hadir')
                                                <span class="badge bg-success">Hadir</span>
                                                @break
                                            @case('izin')
                                                <span class="badge bg-warning text-dark">Izin</span>
                                                @break
                                            @case('sakit')
                                                <span class="badge bg-info text-dark">Sakit</span>
                                                @break
                                            @default
                                                <span class="badge bg-danger">Alfa</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $a->keterangan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="ti ti-info-circle me-1"></i> Belum ada data absensi untuk filter ini
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