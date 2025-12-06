@extends('layouts.app')

@section('title', 'Arsip Pengumuman')

@section('content')
<div class="row">
    <div class="col-md-12">

        {{-- 🔹 Header Judul dan Tombol Kembali --}}
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <h3 class="fw-bold mb-0">
                <i class="ti ti-archive"></i> Arsip Pengumuman
            </h3>
            <a href="{{ route('admin.pengumuman.index') }}" 
               class="btn btn-outline-dark rounded-pill shadow-sm mt-2 mt-md-0 px-4">
                <i class="ti ti-arrow-left"></i> Kembali
            </a>
        </div>

        {{-- 🔹 Jika Kosong --}}
        @if ($pengumuman->isEmpty())
            <div class="alert alert-light border text-center text-muted py-5 rounded-4">
                <i class="ti ti-inbox fs-1"></i>
                <p class="mt-3 mb-0 fs-6">Belum ada pengumuman yang diarsipkan.</p>
            </div>
        @else

        <div class="row g-4">
            @foreach ($pengumuman as $item)
            <div class="col-md-4">
                <div class="card pengumuman-card border-0 shadow-sm h-100">

                    {{-- 🔹 Gambar --}}
                    @if ($item->gambar)
                        <img src="{{ asset('storage/'.$item->gambar) }}" 
                             class="card-img-top"
                             style="height:180px; object-fit:cover;"
                             alt="Gambar">
                    @else
                        <div class="no-image d-flex flex-column justify-content-center align-items-center bg-light text-muted"
                             style="height:180px;">
                            <i class="ti ti-photo-off fs-1"></i>
                            <span class="small mt-2">Tanpa Gambar</span>
                        </div>
                    @endif

                    <div class="card-body">
                        {{-- 🔹 Judul --}}
                        <h5 class="fw-bold text-dark text-truncate mb-2" title="{{ $item->judul }}">
                            {{ $item->judul }}
                        </h5>

                        {{-- 🔹 Informasi --}}
                        <p class="small text-muted mb-1">
                            <i class="ti ti-calendar"></i> 
                            Dibuat: {{ $item->created_at->format('d/m/Y') }}
                        </p>
                        <p class="small text-muted mb-1">
                            <i class="ti ti-clock-stop"></i>
                            Berakhir: {{ \Carbon\Carbon::parse($item->tanggal_berakhir)->format('d/m/Y') }}
                        </p>
                        <p class="small text-muted mb-2">
                            <i class="ti ti-user"></i>
                            {{ $item->user->name ?? 'Tidak diketahui' }}
                        </p>

                        {{-- 🔹 Target --}}
                        <span class="badge rounded-pill bg-gradient-primary shadow-sm px-3 py-1">
                            {{ ucfirst($item->target) }}
                        </span>
                    </div>

                    {{-- 🔹 Footer --}}
                    <div class="card-footer bg-white text-center border-0 pb-3">
                        <a href="{{ route('admin.pengumuman.show', $item->id) }}" 
                           class="btn btn-sm btn-outline-primary rounded-pill px-4 shadow-sm">
                            <i class="ti ti-eye"></i> Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
.pengumuman-card {
    border-radius: 18px;
    overflow: hidden;
    transition: .25s ease-in-out;
}

.pengumuman-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 22px rgba(0,0,0,0.12);
}

.text-truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.bg-gradient-primary {
    background: linear-gradient(45deg, #3b82f6, #2563eb);
    color: white;
}
</style>
@endpush