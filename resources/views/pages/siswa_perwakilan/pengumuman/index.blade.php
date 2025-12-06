@extends('layouts.app-siswa_perwakilan')

@section('title', 'Pengumuman Sekolah')

@section('content')
<div class="row">
    <div class="col-md-12">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="page-title m-0">📢 Pengumuman Sekolah</h3>
    
            <a href="{{ route('siswa_perwakilan.pengumuman.arsip') }}" 
               class="btn btn-outline-secondary btn-sm rounded-pill">
                <i class="ti ti-archive"></i> Lihat Arsip
            </a>
        </div>
    
        @if($featured)
        <div class="card mb-5 shadow-lg border-0 overflow-hidden">
    
            @if ($featured->gambar)
                <img src="{{ asset('storage/' . $featured->gambar) }}" 
                     alt="Gambar Pengumuman" 
                     class="w-100 object-fit-cover" 
                     style="max-height: 260px; object-position: center;">
            @endif
    
            <div class="card-body bg-primary text-white p-4">
                <span class="badge bg-warning text-dark mb-2 px-3 py-1 rounded-pill">Baru</span>
                
                <h3 class="fw-bold mb-3">{{ $featured->judul }}</h3>
    
                <p class="mb-3">{{ Str::limit($featured->isi, 180) }}</p>
    
                <a href="{{ route('siswa_perwakilan.pengumuman.show', $featured->id) }}" 
                   class="btn btn-light btn-sm rounded-pill px-3">
                    <i class="ti ti-eye"></i> Lihat Detail
                </a>
            </div>
    
            <div class="card-footer text-white small bg-dark px-4 py-2">
                Diposting: {{ $featured->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
            </div>
    
        </div>
        @endif
    
        <div class="row g-4">
            @forelse ($others as $item)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden hover-shadow">
    
                        @if ($item->gambar)
                            <div class="position-relative" style="height: 160px;">
                                <img src="{{ asset('storage/' . $item->gambar) }}" 
                                     alt="Gambar Pengumuman" 
                                     class="w-100 h-100 object-fit-cover">
                                <span class="badge bg-primary position-absolute top-0 start-0 m-2 px-3 py-1 rounded-pill">Info</span>
                            </div>
                        @else
                            <div class="bg-light text-center py-5">
                                <i class="ti ti-photo text-muted fs-1"></i>
                                <p class="text-muted small mb-0">Tanpa Gambar</p>
                            </div>
                        @endif
    
                        <div class="card-body p-3">
                            <h5 class="fw-bold mb-1">{{ $item->judul }}</h5>
    
                            <p class="small text-muted mb-2">
                                <i class="ti ti-calendar"></i> 
                                {{ $item->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                            </p>
    
                            <p class="text-truncate mb-3">{{ Str::limit($item->isi, 100) }}</p>
    
                            <a href="{{ route('siswa_perwakilan.pengumuman.show', $item->id) }}" 
                               class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                <i class="ti ti-eye"></i> Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border text-center text-muted py-4">
                        Belum ada pengumuman lain.
                    </div>
                </div>
            @endforelse
        </div>
    
    </div>
</div>
@endsection