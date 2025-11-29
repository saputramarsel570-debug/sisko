@extends('layouts.app-guru')

@section('title', 'Arsip Pengumuman')

@section('content')
<div class="row">
    <div class="col-md-12">

        {{-- 🔹 Header Judul dan Tombol Kembali --}}
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <h3 class="fw-bold mb-0"><i class="ti ti-archive"></i> Arsip Pengumuman</h3>
            <a href="{{ route('guru.pengumuman.index') }}" 
               class="btn btn-outline-dark rounded-pill shadow-sm mt-2 mt-md-0">
                <i class="ti ti-arrow-left"></i> Kembali ke Daftar Aktif
            </a>
        </div>

        {{-- 🔹 Cek Apakah Ada Data --}}
        @if ($pengumuman->isEmpty())
            <div class="alert alert-light border text-center text-muted py-4 rounded-3">
                <i class="ti ti-inbox fs-3"></i>
                <p class="mt-2 mb-0">Belum ada pengumuman yang diarsipkan.</p>
            </div>
        @else
            <div class="row">
                @foreach ($pengumuman as $item)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm border-0 h-100 hover-shadow overflow-hidden">

                            {{-- 🔹 Gambar Pengumuman --}}
                            @if ($item->gambar)
                                <img src="{{ asset('storage/'.$item->gambar) }}" 
                                     alt="Gambar Pengumuman" 
                                     class="w-100" 
                                     style="height:180px; object-fit:cover;">
                            @else
                                <div class="bg-light d-flex flex-column align-items-center justify-content-center text-muted py-5" style="height:180px;">
                                    <i class="ti ti-archive fs-1 mb-2"></i>
                                    <p class="mb-0 small">Tanpa Gambar</p>
                                </div>
                            @endif

                            {{-- 🔹 Isi Card --}}
                            <div class="card-body">
                                <h5 class="fw-bold mb-2 text-dark">{{ $item->judul }}</h5>
                                <p class="small text-muted mb-1">
                                    <i class="ti ti-calendar"></i> 
                                    Dibuat: {{ $item->created_at->format('d/m/Y') }}
                                </p>
                                <p class="small text-muted mb-1">
                                    <i class="ti ti-clock-stop"></i> 
                                    Berakhir: {{ \Carbon\Carbon::parse($item->tanggal_berakhir)->format('d/m/Y') }}
                                </p>
                                <p class="small text-muted mb-2">
                                    <i class="ti ti-user"></i> {{ $item->user->name ?? 'Tidak diketahui' }}
                                </p>
                                <span class="badge bg-primary">{{ ucfirst($item->target) }}</span>
                            </div>

                            {{-- 🔹 Footer Aksi --}}
                            <div class="card-footer bg-light text-center">
                                <a href="{{ route('guru.pengumuman.show', $item->id) }}" 
                                   class="btn btn-sm btn-outline-primary rounded-pill shadow-sm">
                                    <i class="ti ti-eye"></i> Lihat
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
.hover-shadow:hover {
    transform: translateY(-4px);
    transition: all 0.2s ease-in-out;
    box-shadow: 0 6px 16px rgba(0,0,0,0.12);
}
.card-footer {
    border-top: 1px solid rgba(0,0,0,0.05);
}
</style>
@endpush