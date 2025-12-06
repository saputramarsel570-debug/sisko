@extends('layouts.app-siswa')

@section('title', 'Arsip Pengumuman')

@section('content')
<div class="row">
  <div class="col-md-12">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
      <h3 class="fw-bold m-0">
        🗂 Arsip Pengumuman
      </h3>

      <a href="{{ route('siswa.pengumuman.index') }}" 
         class="btn btn-outline-secondary rounded-pill px-4">
        <i class="ti ti-arrow-left"></i> Kembali ke Pengumuman
      </a>
    </div>

    <form action="{{ route('siswa.pengumuman.arsip') }}" method="GET" class="mb-4">
      <div class="input-group input-group-lg">
        <input type="text" 
               name="search" 
               value="{{ request('search') }}"
               class="form-control rounded-start-pill shadow-sm"
               placeholder="Cari pengumuman berdasarkan judul...">

        <button class="btn btn-primary rounded-0" type="submit">
          <i class="ti ti-search"></i>
        </button>

        <a href="{{ route('siswa.pengumuman.arsip') }}"
           class="btn btn-secondary rounded-end-pill">
          <i class="ti ti-refresh"></i>
        </a>
      </div>
    </form>

    @if ($pengumuman->isEmpty())
      <div class="alert alert-light text-center border rounded-4 py-5 shadow-sm">
        <i class="ti ti-info-circle fs-1 text-muted d-block mb-3"></i>
        <h5 class="text-muted fw-semibold mb-1">Belum ada pengumuman yang diarsipkan</h5>
        <p class="text-muted mb-0">Pengumuman yang sudah kadaluarsa akan muncul di sini.</p>
      </div>
    @else

      <div class="row g-4">
        @foreach ($pengumuman as $item)
        <div class="col-md-4">
          <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden archive-card">

            @if ($item->gambar)
              <img src="{{ asset('storage/' . $item->gambar) }}" 
                   alt="Gambar Pengumuman" 
                   class="card-img-top object-fit-cover"
                   style="height: 180px;">
            @else
              <div class="bg-light text-center d-flex align-items-center justify-content-center flex-column"
                   style="height: 180px;">
                <i class="ti ti-file-description fs-1 mb-2 text-secondary"></i>
                <span class="text-muted fw-semibold">Tanpa Gambar</span>
              </div>
            @endif

            <div class="card-body">
              <h6 class="fw-bold mb-2">{{ $item->judul }}</h6>

              <p class="text-muted small mb-2">
                <i class="ti ti-user"></i> {{ $item->user->name ?? '-' }} <br>
                <i class="ti ti-calendar"></i> 
                {{ \Carbon\Carbon::parse($item->tanggal_berakhir)->timezone('Asia/Jakarta')->translatedFormat('d F Y') }}
              </p>

              <p class="text-muted small">
                {!! nl2br(e(Str::limit($item->isi, 110))) !!}
              </p>
            </div>

            <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
              <a href="{{ route('siswa.pengumuman.show', $item->id) }}"
                 class="btn btn-outline-primary btn-sm rounded-pill px-3">
                <i class="ti ti-eye"></i> Lihat
              </a>
              <span class="badge bg-secondary-subtle text-muted">
                <i class="ti ti-archive"></i> Arsip
              </span>
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
  .archive-card {
    transition: 0.25s ease;
  }
  .archive-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 26px rgba(0, 0, 0, 0.12) !important;
  }
  .bg-secondary-subtle {
    background-color: #f1f1f1 !important;
  }
</style>
@endpush