@extends('layouts.app-siswa')

@section('title', 'Detail Pengumuman')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

            {{-- Jika ada gambar, tampilkan di bagian header card --}}
            @if ($pengumuman->gambar)
                <div class="position-relative">
                    <img src="{{ asset('storage/' . $pengumuman->gambar) }}" 
                         alt="Gambar Pengumuman" 
                         class="w-100 object-fit-cover"
                         style="max-height: 350px; object-position: center; cursor: zoom-in;"
                         data-bs-toggle="modal"
                         data-bs-target="#imageModal">

                    <span class="position-absolute top-0 start-0 m-3 badge bg-primary shadow-sm px-3 py-2">
                        Pengumuman
                    </span>
                </div>
            @else
                <div class="bg-light text-center py-5">
                    <i class="ti ti-photo text-muted display-4 d-block mb-2"></i>
                    <p class="text-muted fst-italic mb-0">Tidak ada gambar</p>
                </div>
            @endif

            <div class="card-body p-4">
                <h2 class="fw-bold mb-3">{{ $pengumuman->judul }}</h2>
                <p class="text-muted small mb-4">
                    <i class="ti ti-calendar me-1"></i> 
                    Diposting pada: {{ $pengumuman->created_at->format('d F Y, H:i') }}
                    <br>
                    @if ($pengumuman->tanggal_berakhir)
                        <i class="ti ti-clock me-1"></i> 
                        Berlaku sampai: {{ \Carbon\Carbon::parse($pengumuman->tanggal_berakhir)->translatedFormat('d F Y') }}
                    @else
                        <i class="ti ti-infinity me-1"></i> 
                        Berlaku tanpa batas waktu
                    @endif
                </p>
                
                <p class="fs-5 lh-lg text-justify">
                    {!! nl2br(e($pengumuman->isi)) !!}
                </p>
            </div>

            <div class="card-footer bg-light border-0 d-flex justify-content-end">
                <a href="{{ route('siswa.pengumuman.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="ti ti-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

    </div>
</div>

{{-- Modal Gambar --}}
@if ($pengumuman->gambar)
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-transparent border-0 shadow-none">
      <div class="modal-body p-0 position-relative d-flex justify-content-center align-items-center">
        <img src="{{ asset('storage/' . $pengumuman->gambar) }}" 
             alt="Zoom Gambar Pengumuman" 
             class="w-100 rounded-4 shadow-lg"
             style="max-height: 85vh; object-fit: contain;">
      </div>
    </div>
  </div>
</div>
@endif
@endsection

@push('styles')
<style>
    /* Efek hover ringan di gambar utama */
    .hover-zoom {
        transition: transform 0.2s ease;
    }
    .hover-zoom:hover {
        transform: scale(1.02);
        filter: brightness(0.95);
    }
</style>
@endpush

@push('scripts')
<script>
    // Tutup modal jika klik area luar gambar
    document.addEventListener('click', function(e) {
        const modalBody = document.querySelector('#imageModal .modal-body');
        if (e.target === modalBody) {
            const modalInstance = bootstrap.Modal.getInstance(document.getElementById('imageModal'));
            modalInstance.hide();
        }
    });
</script>
@endpush