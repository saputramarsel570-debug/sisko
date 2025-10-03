@extends('layouts.app-orangtua')

@section('title', 'Detail Pengumuman')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card shadow-lg border-0">
            <div class="card-body p-4">
                <span class="badge bg-primary mb-2">Pengumuman</span>
                <h2 class="fw-bold">{{ $pengumuman->judul }}</h2>
                <p class="text-muted small">Diposting: {{ $pengumuman->created_at->format('d-m-Y H:i') }}</p>
                <hr>
                <p class="fs-5">{!! nl2br(e($pengumuman->isi)) !!}</p>
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('orangtua.pengumuman.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

    </div>
</div>
@endsection