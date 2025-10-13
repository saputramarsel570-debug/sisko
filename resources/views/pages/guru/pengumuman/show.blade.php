@extends('layouts.app-guru')

@section('title', 'Detail Pengumuman')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-primary text-white rounded-top-4 d-flex align-items-center">
                <h4 class="mb-0"><i class="ti ti-bell me-2"></i> Detail Pengumuman</h4>
            </div>

            <div class="card-body bg-light rounded-bottom-4">
                <div class="mb-3">
                    <h6 class="text-primary fw-semibold mb-1">Judul</h6>
                    <div class="p-3 bg-white rounded shadow-sm border">
                        {{ $pengumuman->judul }}
                    </div>
                </div>

                <div class="mb-3">
                    <h6 class="text-primary fw-semibold mb-1">Isi</h6>
                    <div class="p-3 bg-white rounded shadow-sm border" style="min-height: 100px;">
                        {!! nl2br(e($pengumuman->isi)) !!}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <h6 class="text-primary fw-semibold mb-1">Dibuat Oleh</h6>
                        <div class="p-3 bg-white rounded shadow-sm border">
                            {{ $pengumuman->user->name ?? 'Guru' }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary fw-semibold mb-1">Tanggal</h6>
                        <div class="p-3 bg-white rounded shadow-sm border">
                            {{ $pengumuman->created_at->format('d-m-Y H:i') }}
                        </div>
                    </div>
                    @if ($pengumuman->gambar)
                        <div class="mb-3 text-center">
                            <img src="{{ asset('storage/'.$pengumuman->gambar) }}" alt="gambar pengumuman" class="img-fluid rounded shadow-sm">
                        </div>
                    @endif
                </div>

                <div class="text-end mt-4">
                    <a href="{{ route('guru.pengumuman.index') }}" class="btn btn-primary px-4 rounded-3 shadow-sm">
                        <i class="ti ti-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection