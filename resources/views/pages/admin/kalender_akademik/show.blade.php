@extends('layouts.app')

@section('title', 'Detail Kalender Akademik')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h3 class="page-title mb-3">Detail Kalender Akademik</h3>

        <div class="card card-body">
            <div class="mb-3">
                <h5 class="fw-bold">Judul</h5>
                <p>{{ $kalender->judul }}</p>
            </div>

            <div class="mb-3">
                <h5 class="fw-bold">Jenis</h5>
                <p>
                    @switch($kalender->jenis)
                        @case('ujian') Ujian @break
                        @case('rapat') Rapat @break
                        @case('kegiatan') Kegiatan Sekolah @break
                        @case('libur') Libur Nasional @break
                        @default {{ ucfirst($kalender->jenis) }}
                    @endswitch
                </p>
            </div>

            <div class="mb-3">
                <h5 class="fw-bold">Tanggal</h5>
                <p>
                    {{ \Carbon\Carbon::parse($kalender->tanggal_mulai)->format('d M Y') }}
                    s/d
                    {{ \Carbon\Carbon::parse($kalender->tanggal_selesai)->format('d M Y') }}
                </p>
            </div>

            <div class="mb-3">
                <h5 class="fw-bold">Deskripsi</h5>
                <p>{{ $kalender->deskripsi ?? '-' }}</p>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.kalender_akademik.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('admin.kalender_akademik.edit', $kalender->id) }}" class="btn btn-warning">
                    <i class="ti ti-pencil"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
