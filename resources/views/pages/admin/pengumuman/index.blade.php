@extends('layouts.app')

@section('title', 'Halaman Pengumuman Admin')

@section('content')
<div class="row">
    <div class="col-md-12">

        {{-- 🔹 Notifikasi Sukses --}}
        @if (session('success'))
            <div id="success" class="alert alert-solid-success d-flex align-items-center" role="alert">
                <span class="alert-icon rounded"><i class="ti ti-check"></i></span>
                {{ session('success') }}
            </div>
        @endif

        {{-- 🔹 Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <h3 class="fw-bold mb-0">
                <i class="ti ti-megaphone"></i> Pengumuman Admin
            </h3>
        
            <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">

                <a href="{{ route('admin.pengumuman.arsip') }}" 
                   class="btn btn-outline-secondary rounded-pill px-4 shadow-sm">
                    <i class="ti ti-archive"></i> Arsip
                </a>

                <a href="{{ route('admin.pengumuman.create') }}" 
                   class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="ti ti-plus"></i> Tambah
                </a>
            </div>
        </div>

        {{-- 🔹 Grid Pengumuman --}}
        <div class="row g-4">
            @forelse ($pengumuman as $item)
            <div class="col-md-4">
                <div class="card pengumuman-card border-0 shadow-sm h-100">

                    {{-- 🔸 Gambar --}}
                    @if ($item->gambar)
                        <img src="{{ asset('storage/'.$item->gambar) }}" 
                             alt="Gambar Pengumuman" 
                             class="card-img-top"
                             style="height:180px; object-fit:cover;">
                    @else
                        <div class="no-image d-flex flex-column justify-content-center align-items-center bg-light text-muted"
                             style="height:180px;">
                            <i class="ti ti-megaphone fs-1"></i>
                            <span class="small mt-2">Tanpa Gambar</span>
                        </div>
                    @endif

                    <div class="card-body">
                        {{-- 🔸 Judul --}}
                        <h5 class="fw-bold text-dark mb-1 text-truncate" title="{{ $item->judul }}">
                            {{ $item->judul }}
                        </h5>

                        {{-- 🔸 Informasi Pembuat --}}
                        <p class="small text-muted mb-2">
                            <i class="ti ti-user"></i> {{ $item->user->name ?? 'Tidak diketahui' }}
                        </p>

                        {{-- 🔸 Isi singkat --}}
                        <p class="text-muted small mb-0">
                            {!! nl2br(e(Str::limit($item->isi, 110))) !!}
                        </p>
                    </div>

                    {{-- 🔹 Footer Tombol Aksi --}}
                    <div class="card-footer bg-white border-0 text-center pb-3">
                        <div class="d-flex justify-content-center flex-wrap gap-2">

                            <a href="{{ route('admin.pengumuman.show', $item->id) }}" 
                               class="btn btn-sm btn-outline-info rounded-pill px-3 shadow-sm">
                                <i class="ti ti-eye"></i> Lihat
                            </a>

                            <a href="{{ route('admin.pengumuman.edit', $item->id) }}" 
                               class="btn btn-sm btn-outline-primary rounded-pill px-3 shadow-sm">
                                <i class="ti ti-pencil"></i> Edit
                            </a>

                            <button type="button" 
                                onclick="actionDelete('{{ route('admin.pengumuman.destroy', $item->id) }}')" 
                                class="btn btn-sm btn-outline-danger rounded-pill px-3 shadow-sm">
                                <i class="ti ti-trash"></i> Hapus
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-light border text-center text-muted py-5 rounded-4">
                    <i class="ti ti-info-circle fs-2 mb-2"></i>
                    <p class="mb-0">Belum ada data pengumuman.</p>
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
<link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/sweetalert2/sweetalert2.css') }}" />
<style>
.pengumuman-card {
    border-radius: 18px;
    overflow: hidden;
    transition: .25s ease;
}

.pengumuman-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 22px rgba(0,0,0,0.12);
}

.text-truncate {
    max-width: 100%;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
@endpush

@push('scripts')
<script src="{{ asset('/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script>
function actionDelete(url) {
    Swal.fire({
        title: "Hapus Pengumuman?",
        text: "Data yang dihapus tidak bisa dikembalikan.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d"
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
    alert.style.transition = "opacity .5s";
    alert.style.opacity = "0";
    setTimeout(() => alert.remove(), 500);
  }
}, 3000);
</script>
@endpush