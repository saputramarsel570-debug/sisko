@extends('layouts.app-siswa')

@section('title', 'Detail Pengumuman')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            @if ($pengumuman->gambar)
                <div class="position-relative">
                    <img src="{{ asset('storage/' . $pengumuman->gambar) }}" 
                         alt="Gambar Pengumuman" 
                         class="w-100 object-fit-cover" 
                         style="max-height: 350px; object-position: center;">
                    <span class="position-absolute top-0 start-0 m-3 badge bg-primary shadow-sm px-3 py-2">
                        Pengumuman
                    </span>
                </div>
            @else
                <div class="bg-light text-center py-5">
                    <i class="ti ti-photo text-muted display-4 d-block mb-2"></i>
                    <p class="text-muted fst-italic mb-0">Tidak ada gambar</p>
                </div>
            @endif

            <div class="card-body p-4">
                <h2 class="fw-bold mb-3">{{ $pengumuman->judul }}</h2>
                <p class="text-muted small mb-4">
                    <i class="ti ti-calendar me-1"></i> 
                    Diposting pada: {{ $pengumuman->created_at->format('d F Y, H:i') }}
                </p>
                
                <p class="fs-5 lh-lg text-justify">
                    {!! nl2br(e($pengumuman->isi)) !!}
                </p>
            </div>

            <div class="card-footer bg-light border-0 d-flex justify-content-end">
                <a href="{{ route('siswa.pengumuman.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="ti ti-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

    </div>
</div>
@endsection