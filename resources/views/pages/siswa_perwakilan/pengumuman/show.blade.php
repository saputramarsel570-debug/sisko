@extends('layouts.app-siswa_perwakilan')

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

                {{-- tampilkan gambar jika ada --}}
                @if ($pengumuman->gambar)
                    <div class="text-center mb-3">
                        <img src="{{ asset('storage/' . $pengumuman->gambar) }}" 
                             alt="Gambar Pengumuman" 
                             class="img-fluid rounded shadow-sm" 
                             style="max-width: 400px;">
                    </div>
                @else
                    <p class="text-center text-muted fst-italic">Tidak ada gambar</p>
                @endif

                <p class="fs-5 mt-3">{!! nl2br(e($pengumuman->isi)) !!}</p>
            </div>

            <div class="card-footer text-end">
                <a href="{{ route('siswa_perwakilan.pengumuman.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

    </div>
</div>
@endsection