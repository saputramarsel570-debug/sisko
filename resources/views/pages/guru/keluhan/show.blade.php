@extends('layouts.app')

@section('title', 'Detail Keluhan & Saran')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="page-title">Detail Keluhan & Saran</h3>

        <div class="card border-0 shadow-sm rounded-3 p-4">
            <div class="mb-3">
                <label class="fw-bold">Pengirim</label>
                <div class="p-3 border rounded bg-light">
                    {{ $keluhan->user->name ?? '-' }}
                </div>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Kategori</label>
                <div class="p-3 border rounded bg-light">
                    {{ ucfirst($keluhan->kategori) }}
                </div>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Isi</label>
                <div class="p-3 border rounded bg-light">
                    {{ $keluhan->isi }}
                </div>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Status</label>
                <div class="p-3 border rounded bg-light">
                    @if($keluhan->status == 'pending')
                        <span class="badge bg-warning">Pending</span>
                    @elseif($keluhan->status == 'proses')
                        <span class="badge bg-info">Proses</span>
                    @else
                        <span class="badge bg-success">Selesai</span>
                    @endif
                </div>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Balasan</label>
                <div class="p-3 border rounded bg-light">
                    {{ $keluhan->balasan ?? '-' }}
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('guru.keluhan.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('guru.keluhan.edit', $keluhan->id) }}" class="btn btn-warning">
                    <i class="ti ti-pencil"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>
@endsection