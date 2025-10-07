@extends('layouts.app-guru')

@section('title', 'Detail Keluhan & Saran')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">
                    <i class="ti ti-message-2 me-2"></i> Detail Keluhan & Saran
                </h5>
                <a href="{{ route('guru.keluhan.index') }}" class="btn btn-light btn-sm">
                    <i class="ti ti-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <label class="fw-semibold text-secondary">Pengirim</label>
                    <div class="p-3 border rounded bg-body-tertiary">
                        {{ $keluhan->user->name ?? '-' }}
                    </div>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold text-secondary">Kategori</label>
                    <div class="p-3 border rounded bg-body-tertiary">
                        {{ ucfirst($keluhan->kategori) }}
                    </div>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold text-secondary">Isi</label>
                    <div class="p-3 border rounded bg-body-tertiary">
                        {{ $keluhan->isi }}
                    </div>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold text-secondary">Status</label>
                    <div class="p-3 border rounded bg-body-tertiary">
                        @if($keluhan->status == 'pending')
                            <span class="badge bg-warning text-dark px-3 py-2">Pending</span>
                        @elseif($keluhan->status == 'proses')
                            <span class="badge bg-info text-dark px-3 py-2">Proses</span>
                        @else
                            <span class="badge bg-success px-3 py-2">Selesai</span>
                        @endif
                    </div>
                </div>

                <div class="mb-4">
                    <label class="fw-semibold text-secondary">Balasan</label>
                    <div class="p-3 border rounded bg-body-tertiary">
                        {{ $keluhan->balasan ?? '-' }}
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('guru.keluhan.edit', $keluhan->id) }}" class="btn btn-warning px-4">
                        <i class="ti ti-pencil me-1"></i> Edit
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection