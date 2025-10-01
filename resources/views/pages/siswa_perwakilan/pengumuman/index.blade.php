@extends('layouts.app')

@section('title', 'Pengumuman Sekolah')

@section('content')
<div class="row">
    <div class="col-md-12">

        <h3 class="page-title mb-4">📢 Pengumuman Sekolah</h3>

        @if($featured)
        <div class="card mb-5 shadow-lg border-0">
            <div class="card-body bg-primary text-white rounded p-4">
                <span class="badge bg-warning text-dark mb-2">Baru</span>
                <h3 class="fw-bold">{{ $featured->judul }}</h3>
                <p class="mb-3">{{ Str::limit($featured->isi, 180) }}</p>
                <a href="{{ route('siswa_perwakilan.pengumuman.show', $featured->id) }}" class="btn btn-light btn-sm">
                    <i class="ti ti-eye"></i> Lihat Detail
                </a>
            </div>
            <div class="card-footer text-white small bg-dark">
                Diposting: {{ $featured->created_at->format('d-m-Y H:i') }}
            </div>
        </div>
        @endif

        <div class="row">
            @forelse ($others as $item)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 hover-shadow">
                        <div class="card-body">
                            <h5 class="fw-bold">{{ $item->judul }}</h5>
                            <p class="small text-muted mb-2">Diposting: {{ $item->created_at->format('d-m-Y H:i') }}</p>
                            <p class="text-truncate">{{ Str::limit($item->isi, 100) }}</p>
                            <a href="{{ route('siswa_perwakilan.pengumuman.show', $item->id) }}" class="btn btn-outline-primary btn-sm">
                                <i class="ti ti-eye"></i> Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Belum ada pengumuman lain.</p>
            @endforelse
        </div>

    </div>
</div>
@endsection