@extends('layouts.app-guru')

@section('title', 'Halaman Pengumuman Guru')

@section('content')
<div class="row">
    <div class="col-md-12">

        @if (session('success'))
      <div id="success" class="alert alert-solid-success d-flex align-items-center" role="alert">
        <span class="alert-icon rounded"><i class="ti ti-check"></i></span>
        {{ session('success') }}
      </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h3 class="fw-bold mb-0">
            <i class="ti ti-megaphone"></i> Pengumuman Guru
        </h3>
    
        <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
            <a href="{{ route('guru.pengumuman.arsip') }}" class="btn btn-outline-dark rounded-pill shadow-sm">
                <i class="ti ti-archive"></i> Lihat Arsip
            </a>
            <a href="{{ route('guru.pengumuman.create') }}" class="btn btn-primary rounded-pill shadow-sm">
                <i class="ti ti-plus"></i> Tambah Pengumuman
            </a>
        </div>
    </div>

        <div class="row">
            @forelse ($pengumuman as $item)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-0 h-100 hover-shadow overflow-hidden">

                        {{-- 🔹 Gambar Pengumuman --}}
                        @if ($item->gambar)
                            <img src="{{ asset('storage/'.$item->gambar) }}" 
                                 alt="Gambar Pengumuman" 
                                 class="w-100" 
                                 style="height:180px; object-fit:cover;">
                        @else
                            {{-- 🔸 Placeholder jika tidak ada gambar --}}
                            <div class="bg-light d-flex flex-column align-items-center justify-content-center text-muted py-5" style="height:180px;">
                                <i class="ti ti-megaphone fs-1 mb-2"></i>
                                <p class="mb-0 small">Tanpa Gambar</p>
                            </div>
                        @endif

                        {{-- 🔹 Isi Card --}}
                        <div class="card-body">
                            <h5 class="fw-bold mb-2 text-primary">{{ $item->judul }}</h5>

                            <p class="small text-muted mb-2">
                                <i class="ti ti-user"></i> {{ $item->user->name ?? 'Tidak diketahui' }}
                            </p>

                            {{-- 🔥 Tanggal WIB ditambahkan --}}
                            <p class="small text-muted mb-2">
                                <i class="ti ti-calendar"></i>
                                {{ $item->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                            </p>

                            <p class="text-muted mb-3">{!! nl2br(e(Str::limit($item->isi, 100))) !!}</p>
                        </div>

                        {{-- 🔹 Footer Aksi --}}
                        <div class="card-footer bg-light text-center d-flex justify-content-center gap-2 flex-wrap">
                            <a href="{{ route('guru.pengumuman.show', $item->id) }}" 
                               class="btn btn-sm btn-info text-white rounded-pill shadow-sm">
                                <i class="ti ti-eye"></i> Lihat
                            </a>
                            <a href="{{ route('guru.pengumuman.edit', $item->id) }}" 
                               class="btn btn-sm btn-primary rounded-pill shadow-sm">
                                <i class="ti ti-pencil"></i> Edit
                            </a>
                            <button type="button" 
                                onclick="actionDelete('{{ route('guru.pengumuman.destroy', $item->id) }}')" 
                                class="btn btn-sm btn-danger rounded-pill shadow-sm">
                                <i class="ti ti-trash"></i> Hapus
                            </button>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border text-center text-muted py-4">
                        Belum ada data pengumuman.
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
.hover-shadow:hover {
    transform: translateY(-4px);
    transition: all 0.2s ease-in-out;
    box-shadow: 0 6px 16px rgba(0,0,0,0.12);
}
.card-footer {
    border-top: 1px solid rgba(0,0,0,0.05);
}
</style>
@endpush

@push('scripts')
<script src="{{ asset('/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script>
function actionDelete(url) {
    Swal.fire({
        title: "Yakin mau dihapus?",
        text: "Data yang dihapus tidak bisa dikembalikan!",
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