@extends('layouts.app-orangtua')

@section('title', 'Pengumuman Sekolah')

@section('content')
<div class="row">
    <div class="col-md-12">

        <h3 class="page-title mb-4">📢 Pengumuman Sekolah</h3>

        {{-- 🔹 Pengumuman Unggulan (Featured) --}}
        @if($featured)
        <div class="card mb-5 shadow-lg border-0 overflow-hidden">
            @if ($featured->gambar)
                <img src="{{ asset('storage/' . $featured->gambar) }}" 
                     alt="Gambar Pengumuman" 
                     class="w-100 object-fit-cover" 
                     style="max-height: 250px; object-position: center;">
            @endif
            <div class="card-body bg-primary text-white p-4">
                <span class="badge bg-warning text-dark mb-2">Baru</span>
                <h3 class="fw-bold mb-3">{{ $featured->judul }}</h3>
                <p class="mb-3">{{ Str::limit($featured->isi, 180) }}</p>
                <a href="{{ route('orangtua.pengumuman.show', $featured->id) }}" class="btn btn-light btn-sm rounded-pill">
                    <i class="ti ti-eye"></i> Lihat Detail
                </a>
            </div>
            <div class="card-footer text-white small bg-dark">
                Diposting: {{ $featured->created_at->format('d-m-Y H:i') }}
            </div>
        </div>
        @endif

        {{-- 🔹 Daftar Pengumuman Lain --}}
        <div class="row">
            @forelse ($others as $item)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 hover-shadow overflow-hidden">

                        {{-- Gambar kecil --}}
                        @if ($item->gambar)
                            <div class="position-relative" style="height: 150px;">
                                <img src="{{ asset('storage/' . $item->gambar) }}" 
                                     alt="Gambar Pengumuman" 
                                     class="w-100 h-100 object-fit-cover">
                                <span class="badge bg-primary position-absolute top-0 start-0 m-2">Info</span>
                            </div>
                        @else
                            <div class="bg-light text-center py-5">
                                <i class="ti ti-photo text-muted fs-1"></i>
                                <p class="text-muted small mb-0">Tanpa Gambar</p>
                            </div>
                        @endif

                        <div class="card-body">
                            <h5 class="fw-bold mb-1">{{ $item->judul }}</h5>
                            <p class="small text-muted mb-2">
                                <i class="ti ti-calendar"></i> {{ $item->created_at->format('d-m-Y H:i') }}
                            </p>
                            <p class="text-truncate mb-3">{{ Str::limit($item->isi, 100) }}</p>
                            <a href="{{ route('orangtua.pengumuman.show', $item->id) }}" 
                               class="btn btn-outline-primary btn-sm rounded-pill">
                                <i class="ti ti-eye"></i> Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border text-center text-muted">
                        Belum ada pengumuman lain.
                    </div>
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection