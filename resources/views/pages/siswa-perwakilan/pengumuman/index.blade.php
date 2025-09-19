@extends('layouts.app')

@section('title', 'Pengumuman Sekolah')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="page-title">Pengumuman Sekolah</h3>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row">
                    @forelse ($pengumuman as $item)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->judul }}</h5>
                                    <p class="card-text text-truncate">
                                        {{ Str::limit($item->isi, 100) }}
                                    </p>
                                    <a href="{{ route('siswa-perwakilan.pengumuman.show', $item->id) }}" 
                                       class="btn btn-sm btn-primary">
                                        <span class="ti ti-eye me-1"></span> Detail
                                    </a>
                                </div>
                                <div class="card-footer text-muted small">
                                    Diposting: {{ $item->created_at->format('d-m-Y H:i') }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Belum ada pengumuman.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection