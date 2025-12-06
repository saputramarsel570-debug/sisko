@extends('layouts.app')

@section('title', 'Detail Keluhan & Saran')

@section('content')
<div class="row justify-content-center">
  <div class="col-lg-8">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

      {{-- Header --}}
      <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
          <i class="ti ti-message-2 me-2"></i> Detail Keluhan & Saran
        </h5>
        <span class="badge 
          @if($keluhan->status === 'pending') bg-warning text-dark
          @elseif($keluhan->status === 'proses') bg-info text-dark
          @else bg-success text-white @endif 
          px-3 py-2 rounded-pill">
          {{ ucfirst($keluhan->status) }}
        </span>
      </div>

      {{-- Body --}}
      <div class="card-body p-4 bg-light-subtle">

        {{-- Grid Informasi --}}
        <div class="row g-4">

          <div class="col-md-6">
            <div class="info-box">
              <label>Dibuat Oleh</label>
              <div class="value">{{ $keluhan->user->name ?? '-' }}</div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="info-box">
              <label>Kategori</label>
              <div class="value text-capitalize">{{ $keluhan->kategori }}</div>
            </div>
          </div>

          <div class="col-12">
            <div class="info-box">
              <label>Isi</label>
              <div class="value" style="white-space: pre-line;">
                {{ $keluhan->isi }}
              </div>
            </div>
          </div>

          <div class="col-12">
            <div class="info-box">
              <label>Balasan</label>
              <div class="value" style="white-space: pre-line;">
                {{ $keluhan->balasan ?? '-' }}
              </div>
            </div>
          </div>

        </div>

        {{-- Gambar --}}
        @if($keluhan->gambar)
          <div class="mt-4 text-center">
            <label class="fw-semibold text-secondary d-block mb-2">Lampiran Gambar</label>

            <div class="image-wrapper">
              <img src="{{ asset('storage/' . $keluhan->gambar) }}"
                   alt="Gambar Keluhan"
                   class="img-fluid rounded-4 shadow-sm preview-image"
                   data-bs-toggle="modal" data-bs-target="#modalGambar">
            </div>
          </div>

          {{-- Modal Foto --}}
          <div class="modal fade" id="modalGambar" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
              <div class="modal-content bg-transparent border-0">
                <div class="text-center">
                  <img src="{{ asset('storage/' . $keluhan->gambar) }}"
                       class="img-fluid rounded-4 shadow-lg modal-image"
                       alt="Gambar Keluhan">
                </div>
              </div>
            </div>
          </div>
        @endif

        {{-- Tombol --}}
        <div class="d-flex justify-content-between mt-4">
          <a href="{{ route('admin.keluhan_saran.index') }}" 
             class="btn btn-outline-primary px-4 rounded-pill">
            <i class="ti ti-arrow-left me-1"></i> Kembali
          </a>

          <a href="{{ route('admin.keluhan_saran.edit', $keluhan->id) }}" 
             class="btn btn-warning px-4 rounded-pill">
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

  .info-box label {
    font-weight: 600;
    color: #6c757d;
    margin-bottom: 4px;
    display: block;
  }

  .info-box .value {
    background: #fff;
    border: 1px solid #e5e7eb;
    padding: 12px 14px;
    border-radius: 12px;
    box-shadow: inset 0 1px 3px rgba(0,0,0,0.03);
    font-size: 0.95rem;
  }

  .image-wrapper {
    display: inline-block;
    max-width: 100%;
    border-radius: 16px;
    overflow: hidden;
    transition: 0.3s ease;
  }

  .preview-image {
    border-radius: 16px;
    cursor: zoom-in;
    transition: transform .3s ease, box-shadow .3s ease;
    max-height: 320px;
    object-fit: cover;
  }

  .preview-image:hover {
    transform: scale(1.02);
    box-shadow: 0 6px 18px rgba(0,0,0,0.2);
  }

  .modal-image {
    max-height: 85vh;
    object-fit: contain;
  }

  .card-header h5 {
    font-weight: 600;
  }
</style>
@endpush