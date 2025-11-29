@extends('layouts.app-siswa')

@section('title', 'Arsip Pengumuman')

@section('content')
<div class="row">
  <div class="col-md-12">

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
      <h4 class="fw-semibold">
        🗂 Arsip Pengumuman
      </h4>
    
      <a href="{{ route('siswa.pengumuman.index') }}" class="btn btn-secondary">
        <i class="ti ti-arrow-left"></i> Kembali ke Pengumuman Aktif
      </a>
    </div>
    
    {{-- 🔍 Form Pencarian --}}
    <form action="{{ route('siswa.pengumuman.arsip') }}" method="GET" class="mb-4">
      <div class="input-group">
        <input type="text" name="search" value="{{ request('search') }}" 
               class="form-control rounded-start-pill"
               placeholder="Cari pengumuman berdasarkan judul...">
        <button class="btn btn-primary rounded-end-pill" type="submit">
          <i class="ti ti-search"></i> Cari
        </button>
        <a href="{{ route('siswa.pengumuman.arsip') }}"
        class="btn btn-secondary">
       <i class="ti ti-refresh"></i> Semua
     </a>
      </div>
    </form>

    {{-- 🔹 Daftar Arsip --}}
    @if ($pengumuman->isEmpty())
      <div class="alert alert-light border text-center text-muted rounded-4 py-4">
        <i class="ti ti-info-circle"></i> Belum ada pengumuman yang diarsipkan.
      </div>
    @else
      <div class="row g-4">
        @foreach ($pengumuman as $item)
          <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100 rounded-4 overflow-hidden hover-card">
              
              {{-- Gambar jika ada --}}
              @if ($item->gambar)
                <img src="{{ asset('storage/' . $item->gambar) }}" 
                     alt="Gambar Pengumuman" 
                     class="card-img-top object-fit-cover"
                     style="height: 180px; object-position: center;">
              @else
                <div class="bg-secondary-subtle text-center d-flex align-items-center justify-content-center flex-column"
                     style="height: 180px;">
                  <i class="ti ti-file-text fs-1 mb-2 text-secondary"></i>
                  <span class="fw-semibold">Pengumuman</span>
                </div>
              @endif

              <div class="card-body">
                <h6 class="fw-bold mb-2">{{ $item->judul }}</h6>
                <p class="text-muted small mb-2">
                  <i class="ti ti-user"></i> {{ $item->user->name ?? '-' }} <br>
                  <i class="ti ti-calendar"></i> 
                  {{ \Carbon\Carbon::parse($item->tanggal_berakhir)->translatedFormat('d F Y') }}
                </p>

                @if (Str::length($item->isi) > 100)
                  <p class="text-muted small">{!! nl2br(e(Str::limit($item->isi, 100))) !!}</p>
                @else
                  <p class="text-muted small">{!! nl2br(e($item->isi)) !!}</p>
                @endif
              </div>

              <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center flex-wrap">
                <a href="{{ route('siswa.pengumuman.show', $item->id) }}" 
                   class="btn btn-sm btn-outline-primary rounded-pill">
                  <i class="ti ti-eye"></i> Lihat
                </a>
                <small class="text-muted"><i class="ti ti-archive"></i> Arsip</small>
              </div>

            </div>
          </div>
        @endforeach
      </div>
    @endif

  </div>
</div>
@endsection

@push('styles')
<style>
  .hover-card:hover {
    transform: translateY(-5px);
    transition: all 0.25s ease;
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
  }
  .bg-secondary-subtle {
    background-color: #f3f3f3 !important;
  }
</style>
@endpush