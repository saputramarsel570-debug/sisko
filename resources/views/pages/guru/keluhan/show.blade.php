@extends('layouts.app-guru')

@section('title', 'Detail Keluhan & Saran')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

      {{-- Header --}}
      <div class="card-header bg-primary text-white py-3">
        <h5 class="mb-0">
          <i class="ti ti-message-2 me-2"></i> Detail Keluhan & Saran
        </h5>
      </div>

      {{-- Body --}}
      <div class="card-body p-4 bg-light-subtle">

        <div class="mb-3">
          <label class="fw-semibold text-secondary d-block mb-1">Dibuat Oleh</label>
          <div class="form-control bg-white border-0 shadow-sm" readonly>
            {{ $keluhan->user->name ?? '-' }}
          </div>
        </div>

        <div class="mb-3">
          <label class="fw-semibold text-secondary d-block mb-1">Kategori</label>
          <div class="form-control bg-white border-0 shadow-sm" readonly>
            {{ ucfirst($keluhan->kategori) }}
          </div>
        </div>

        <div class="mb-3">
          <label class="fw-semibold text-secondary d-block mb-1">Isi</label>
          <div class="form-control bg-white border-0 shadow-sm" style="white-space: pre-line; min-height: 100px;" readonly>
            {{ $keluhan->isi }}
          </div>
        </div>

        <div class="mb-3">
          <label class="fw-semibold text-secondary d-block mb-1">Status</label>
          <div class="form-control bg-white border-0 shadow-sm" readonly>
            @if($keluhan->status == 'pending')
              <span class="badge bg-warning text-dark px-3 py-2">Pending</span>
            @elseif($keluhan->status == 'proses')
              <span class="badge bg-info text-dark px-3 py-2">Proses</span>
            @else
              <span class="badge bg-success px-3 py-2">Selesai</span>
            @endif
          </div>
        </div>

        <div class="mb-3">
          <label class="fw-semibold text-secondary d-block mb-1">Balasan</label>
          <div class="form-control bg-white border-0 shadow-sm" style="white-space: pre-line; min-height: 80px;" readonly>
            {{ $keluhan->balasan ?? '-' }}
          </div>
        </div>

        {{-- Foto --}}
        @if(isset($keluhan) && $keluhan->gambar)
          <div class="mb-4 text-center">
            <label class="fw-semibold text-secondary d-block mb-2">Lampiran Gambar</label>
            <img src="{{ asset('storage/' . $keluhan->gambar) }}"
                 alt="Gambar Keluhan"
                 class="img-thumbnail rounded-4 shadow-sm hover-zoom"
                 style="max-width: 100%; height: auto; cursor: pointer; object-fit: contain;"
                 data-bs-toggle="modal" data-bs-target="#modalGambar">
          </div>

          {{-- Modal Foto --}}
          <div class="modal fade" id="modalGambar" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
              <div class="modal-content bg-transparent border-0">
                <div class="text-center">
                  <img src="{{ asset('storage/' . $keluhan->gambar) }}" 
                       class="img-fluid rounded-4 shadow-lg"
                       style="max-height: 85vh; object-fit: contain;" 
                       alt="Gambar Keluhan">
                </div>
              </div>
            </div>
          </div>
        @endif

        {{-- Tombol --}}
        <div class="d-flex justify-content-between mt-4">
          <a href="{{ route('guru.keluhan.index') }}" class="btn btn-primary px-4">
            <i class="ti ti-arrow-left me-1"></i> Kembali
          </a>
          <a href="{{ route('guru.keluhan.edit', $keluhan->id) }}" class="btn btn-warning px-4">
            <i class="ti ti-pencil me-1"></i> Edit
          </a>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
  .bg-light-subtle {
    background-color: #f8fafc !important;
  }

  .hover-zoom {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .hover-zoom:hover {
    transform: scale(1.02);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
  }

  .form-control[readonly] {
    background-color: #fff !important;
    opacity: 1;
    cursor: default;
  }
</style>
@endpush