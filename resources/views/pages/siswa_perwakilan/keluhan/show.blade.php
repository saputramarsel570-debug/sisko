@extends('layouts.app-siswa_perwakilan')

@section('title', 'Detail Keluhan & Saran')

@section('content')
<div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-primary text-white rounded-top-4 d-flex align-items-center">
                <i class="ti ti-message-2 me-2"></i>
                <h4 class="mb-0 fw-semibold">Detail Keluhan & Saran</h4>
            </div>

            <div class="card-body">
                {{-- Kategori --}}
                <div class="mb-3 p-3 border rounded bg-light mt-3">
                    <label class="fw-bold d-block">Kategori</label>
                    <p class="mb-0">{!! nl2br(e($keluhan->kategori)) !!}</p>
                </div>

                {{-- Isi --}}
                <div class="mb-3 p-3 border rounded bg-light">
                    <label class="fw-bold d-block">Isi</label>
                    <p class="mb-0">{!! nl2br(e($keluhan->isi)) !!}</p>
                </div>

                {{-- Status --}}
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

                {{-- Balasan --}}
                <div class="mb-3 p-3 border rounded bg-light">
                    <label class="fw-bold d-block">Balasan</label>
                    <p class="mb-0">{!! nl2br(e($keluhan->balasan ?? '-')) !!}</p>
                </div>

                {{-- Gambar --}}
                @if(isset($keluhan) && $keluhan->gambar)
                    <div class="mb-3 p-3 border rounded bg-light d-flex flex-column align-items-center justify-content-center text-center">
                        <label class="fw-bold d-block mb-2">Gambar</label>
                        <div class="d-flex justify-content-center align-items-center" style="min-height: 220px;">
                            <img src="{{ asset('storage/' . $keluhan->gambar) }}" 
                                alt="Gambar Keluhan" 
                                class="img-thumbnail rounded shadow-sm"
                                style="max-width: 250px; cursor: pointer; object-fit: contain;"
                                data-bs-toggle="modal" 
                                data-bs-target="#imageModal">
                        </div>
                    </div>
                @endif

            <div class="card-footer d-flex justify-content">
                <a href="{{ route('siswa_perwakilan.keluhan.index') }}" class="btn btn-secondary">
                    <span class="ti ti-arrow-left me-1"></span> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Modal Preview Gambar --}}
@if(isset($keluhan) && $keluhan->gambar)
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body text-center">
                <img src="{{ asset('storage/' . $keluhan->gambar) }}" 
                     class="img-fluid rounded shadow" 
                     alt="Preview Gambar">
            </div>
        </div>
    </div>
</div>
@endif
@endsection