@extends('layouts.app')

@section('title', 'Detail Keluhan & Saran')

@section('content')
<div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Detail Keluhan & Saran</h5>
            </div>
            <div class="card-body">
                <div class="mb-3 p-3 border rounded bg-light">
                    <label class="fw-bold d-block">Kategori</label>
                    <p class="mb-0">{{ ucfirst($keluhan->kategori) }}</p>
                </div>
                <div class="mb-3 p-3 border rounded bg-light">
                    <label class="fw-bold d-block">Isi</label>
                    <p class="mb-0">{{ $keluhan->isi }}</p>
                </div>
                <div class="mb-3 p-3 border rounded bg-light">
                    <label class="fw-bold d-block">Status</label>
                    <p class="mb-0">
                        @if($keluhan->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($keluhan->status == 'proses')
                            <span class="badge bg-info">Proses</span>
                        @else
                            <span class="badge bg-success">Selesai</span>
                        @endif
                    </p>
                </div>
                <div class="mb-3 p-3 border rounded bg-light">
                    <label class="fw-bold d-block">Balasan</label>
                    <p class="mb-0">{{ $keluhan->balasan ?? '-' }}</p>
                </div>
            </div>
            <div class="card-footer d-flex justify-content">
                <a href="{{ route('siswa.keluhan.index') }}" class="btn btn-secondary">
                    <span class="ti ti-arrow-left me-1"></span> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection