@extends('layouts.app')

@section('title', 'Keluhan & Saran Siswa')

@section('content')
<div class="row">
  <div class="col-md-12">

    {{-- ✅ Notifikasi --}}
    @if (session('success'))
      <div id="success" class="alert alert-solid-success d-flex align-items-center" role="alert">
        <span class="alert-icon rounded"><i class="ti ti-check"></i></span>
        {{ session('success') }}
      </div>
    @endif

    {{-- ✅ Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
      <h4 class="fw-semibold">
        <i class="ti ti-message-dots text-primary me-2"></i> Keluhan & Saran Siswa / Orangtua
      </h4>
    </div>

    {{-- 🔹 Filter --}}
    <div class="card shadow-sm border-0 mb-3 rounded-4">
      <div class="card-body d-flex flex-wrap align-items-center gap-3">
        @php
          $kategori = request('kategori');
          $status = request('status');
        @endphp

        {{-- 🔹 Kategori --}}
        <div class="d-flex align-items-center gap-2 flex-wrap">
          <span class="fw-semibold text-secondary">
            <i class="ti ti-category me-1"></i> Kategori:
          </span>

          <a href="{{ route('admin.keluhan_saran.index', array_merge(request()->query(), ['kategori' => 'Keluhan'])) }}"
            class="btn btn-danger btn-sm text-nowrap {{ $kategori == 'Keluhan' ? 'disabled' : '' }}">
           <i class="ti ti-alert-circle"></i> Keluhan
         </a>
         
         <a href="{{ route('admin.keluhan_saran.index', array_merge(request()->query(), ['kategori' => 'Saran'])) }}"
            class="btn btn-success btn-sm text-nowrap {{ $kategori == 'Saran' ? 'disabled' : '' }}">
           <i class="ti ti-bulb"></i> Saran
         </a>
        </div>

        {{-- 🔹 Balasan --}}
        <div class="d-flex align-items-center gap-2 flex-wrap ms-auto">
          <span class="fw-semibold text-secondary">
            <i class="ti ti-message-check me-1"></i> Balasan:
          </span>

          <a href="{{ route('admin.keluhan_saran.index', array_filter([
                'kategori'      => request('kategori'),
                'status'        => request('status'),
                'balasan'       => 'sudah',
                'search'        => request('search'),
                'tanggal_awal'  => request('tanggal_awal'),
                'tanggal_akhir' => request('tanggal_akhir'),
            ])) }}"
            class="btn btn-success btn-sm flex-shrink-0 text-nowrap {{ request('balasan') == 'sudah' ? 'disabled' : '' }}">
            <i class="ti ti-message-check"></i> Sudah Dibalas
          </a>

          <a href="{{ route('admin.keluhan_saran.index', array_filter([
                'kategori'      => request('kategori'),
                'status'        => request('status'),
                'balasan'       => 'belum',
                'search'        => request('search'),
                'tanggal_awal'  => request('tanggal_awal'),
                'tanggal_akhir' => request('tanggal_akhir'),
            ])) }}"
            class="btn btn-secondary btn-sm flex-shrink-0 text-nowrap {{ request('balasan') == 'belum' ? 'disabled' : '' }}">
            <i class="ti ti-message-off"></i> Belum Dibalas
          </a>
        </div>

        {{-- 🔹 Status --}}
        <div class="d-flex align-items-center gap-2 flex-wrap ms-auto">
          <span class="fw-semibold text-secondary">
            <i class="ti ti-list-check me-1"></i> Status:
          </span>

          <a href="{{ route('admin.keluhan_saran.index', array_merge(request()->query(), ['status' => 'pending'])) }}"
            class="btn btn-warning btn-sm text-nowrap {{ $status == 'pending' ? 'disabled' : '' }}">
           <i class="ti ti-clock"></i> Pending
         </a>
         
         <a href="{{ route('admin.keluhan_saran.index', array_merge(request()->query(), ['status' => 'proses'])) }}"
            class="btn btn-info btn-sm text-nowrap {{ $status == 'proses' ? 'disabled' : '' }}">
           <i class="ti ti-loader-2"></i> Proses
         </a>
         
         <a href="{{ route('admin.keluhan_saran.index', array_merge(request()->query(), ['status' => 'selesai'])) }}"
            class="btn btn-success btn-sm text-nowrap {{ $status == 'selesai' ? 'disabled' : '' }}">
           <i class="ti ti-check"></i> Selesai
         </a>

          <a href="{{ route('admin.keluhan_saran.index') }}"
             class="btn btn-secondary btn-sm flex-shrink-0 text-nowrap {{ !$kategori && !$status && !request('search') ? 'disabled' : '' }}">
            <i class="ti ti-refresh"></i> Semua
          </a>
        </div>
      </div>
    </div>

    {{-- 📅 Filter Tanggal --}}
    <form action="{{ route('admin.keluhan_saran.index') }}" method="GET" class="card shadow-sm border-0 mb-3 rounded-4">
      <div class="card-body d-flex flex-wrap align-items-end gap-3">

          <div>
              <label class="fw-semibold">Tanggal Awal</label>
              <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}"
                    class="form-control rounded-pill shadow-sm">
          </div>

          <div>
              <label class="fw-semibold">Tanggal Akhir</label>
              <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
                    class="form-control rounded-pill shadow-sm">
          </div>

          {{-- Pertahankan semua filter lainnya --}}
          @foreach(['kategori','status','search','balasan'] as $key)
              @if(request($key))
                  <input type="hidden" name="{{ $key }}" value="{{ request($key) }}">
              @endif
          @endforeach

          <div>
              <button type="submit" class="btn btn-primary rounded-pill shadow-sm mt-3">
                  <i class="ti ti-filter"></i> Terapkan
              </button>
          </div>

          @if(request('tanggal_awal') || request('tanggal_akhir'))
          <div>
              <a href="{{ route('admin.keluhan_saran.index', array_merge(request()->except(['tanggal_awal','tanggal_akhir']))) }}"
                class="btn btn-secondary rounded-pill shadow-sm mt-3">
                  <i class="ti ti-x"></i> Reset
              </a>
          </div>
          @endif

      </div>
    </form>

    {{-- 🔍 Pencarian Nama --}}
    <div class="card shadow-sm border-0 mb-4 rounded-4">
      <div class="card-body">
        <form action="{{ route('admin.keluhan_saran.index') }}" method="GET" class="d-flex align-items-center flex-wrap gap-2">
          {{-- Pertahankan semua filter --}}
          @foreach(['kategori','status','balasan','tanggal_awal','tanggal_akhir'] as $key)
            @if(request($key))
              <input type="hidden" name="{{ $key }}" value="{{ request($key) }}">
            @endif
          @endforeach

          <div class="flex-grow-1">
            <input type="text" name="search" value="{{ request('search') }}" 
                   class="form-control rounded-pill shadow-sm" placeholder="Cari berdasarkan nama user/isi keluhan...">
          </div>

          <button type="submit" class="btn btn-primary rounded-pill shadow-sm">
            <i class="ti ti-search"></i> Cari
          </button>

          @if(request('search'))
          <a href="{{ route('admin.keluhan_saran.index', array_merge(request()->query(), ['search' => null])) }}"
            class="btn btn-secondary rounded-pill shadow-sm">
           <i class="ti ti-x"></i> Reset
         </a>
          @endif
        </form>
      </div>
    </div>

    {{-- ✅ Daftar Keluhan --}}
    <div class="row g-4">
      @forelse ($keluhan->sortByDesc('created_at') as $item)
        @php
          $icon = match($item->kategori) {
            'akademik' => 'ti-book',
            'fasilitas' => 'ti-building',
            'keamanan' => 'ti-shield-lock',
            default => 'ti-message-2'
          };
          $bgColor = match($item->kategori) {
            'akademik' => 'bg-primary-subtle text-primary',
            'fasilitas' => 'bg-success-subtle text-success',
            'keamanan' => 'bg-warning-subtle text-warning',
            default => 'bg-secondary-subtle text-secondary'
          };
        @endphp

        <div class="col-md-4">
          <div class="card shadow-sm border-0 h-100 rounded-4 overflow-hidden hover-card">
            {{-- Gambar / Placeholder --}}
            @if ($item->gambar)
              <img src="{{ asset('storage/' . $item->gambar) }}"
                   alt="Gambar {{ $item->kategori }}"
                   class="card-img-top object-fit-cover"
                   style="height: 180px; object-position: center;">
            @else
              <div class="{{ $bgColor }} text-center d-flex align-items-center justify-content-center flex-column"
                   style="height: 180px;">
                <i class="ti {{ $icon }} fs-1 mb-2"></i>
                <span class="fw-semibold text-capitalize">{{ $item->kategori }}</span>
              </div>
            @endif

            <div class="card-body">
              <span class="badge bg-primary mb-2 text-capitalize">{{ $item->kategori }}</span>
              <p class="small text-muted mb-2">
                <i class="ti ti-user"></i> {{ $item->user->name ?? '-' }} <br>
                <i class="ti ti-calendar"></i> {{ $item->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}
              </p>
              <p class="text-muted small mb-3">{!! nl2br(e(Str::limit($item->isi, 200))) !!}</p>

              <span class="badge 
                @if($item->status == 'pending') bg-warning text-dark
                @elseif($item->status == 'proses') bg-info text-dark
                @else bg-success @endif">
                {{ ucfirst($item->status) }}
              </span>
            </div>

            <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
              <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.keluhan_saran.show', $item->id) }}" class="btn btn-primary">
                  <i class="ti ti-eye"></i> Lihat
                </a>
                <a href="{{ route('admin.keluhan_saran.edit', $item->id) }}" class="btn btn-warning">
                  <i class="ti ti-pencil"></i> Edit
                </a>
                <a href="javascript:;" onclick="actionDelete('{{ route('admin.keluhan_saran.destroy', $item->id) }}')" class="btn btn-danger">
                  <i class="ti ti-trash"></i> Hapus
                </a>
              </div>

              @if($item->balasan)
                <small class="text-success"><i class="ti ti-message"></i> Sudah dibalas</small>
              @endif
            </div>
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="alert alert-light border text-center text-muted">
            <i class="ti ti-info-circle"></i> Belum ada keluhan atau saran.
          </div>
        </div>
      @endforelse
    </div>
  </div>
</div>

<form id="form-delete" action="" method="POST" class="d-none">
  @csrf
  @method('DELETE')
</form>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('/vendor/libs/sweetalert2/sweetalert2.css') }}" />
<style>
  .hover-card:hover {
    transform: translateY(-4px);
    transition: all 0.25s ease;
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
  }
  .bg-primary-subtle { background-color: #e9f3ff !important; }
  .bg-success-subtle { background-color: #e8f8ef !important; }
  .bg-warning-subtle { background-color: #fff7e6 !important; }
  .bg-secondary-subtle { background-color: #f3f3f3 !important; }
  .btn.disabled {
    opacity: 0.6;
    pointer-events: none;
  }
</style>
@endpush

@push('scripts')
<script src="{{ asset('/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script>
function actionDelete(url) {
  Swal.fire({
    title: "Yakin mau dihapus?",
    text: "Data yang dihapus tidak dapat dikembalikan!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Ya, hapus!",
    cancelButtonText: "Batal",
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33"
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('form-delete').action = url;
      document.getElementById('form-delete').submit();
    }
  });
}

setTimeout(() => {
  const alert = document.getElementById('success');
  if (alert) {
    alert.style.transition = "opacity 0.5s";
    alert.style.opacity = 0;
    setTimeout(() => alert.remove(), 500);
  }
}, 3000);
</script>
@endpush