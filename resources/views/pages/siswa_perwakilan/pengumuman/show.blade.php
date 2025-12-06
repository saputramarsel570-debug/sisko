@extends('layouts.app-siswa_perwakilan')

@section('title', 'Detail Pengumuman')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">

        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

            @if ($pengumuman->gambar)
            <div class="position-relative">
                <img src="{{ asset('storage/' . $pengumuman->gambar) }}" 
                     alt="Gambar Pengumuman" 
                     class="w-100 hover-zoom object-fit-cover"
                     style="max-height: 380px; object-position: center; cursor: zoom-in;"
                     data-bs-toggle="modal"
                     data-bs-target="#imageModal">

                <span class="position-absolute top-0 start-0 m-3 badge bg-primary px-3 py-2 rounded-pill shadow">
                    Pengumuman
                </span>
            </div>
            @else
            <div class="bg-light text-center py-5">
                <i class="ti ti-photo text-muted display-3 d-block mb-3"></i>
                <p class="text-muted fst-italic mb-0">Tidak ada gambar tersedia</p>
            </div>
            @endif

            <div class="card-body p-4">

                <h2 class="fw-bold mb-3">{{ $pengumuman->judul }}</h2>

                <div class="bg-light rounded-3 px-3 py-2 mb-4 small text-muted">
                    <div class="d-flex align-items-center mb-1">
                        <i class="ti ti-calendar me-2"></i>
                        Diposting: 
                        {{ $pengumuman->created_at->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') }}
                    </div>

                    @if ($pengumuman->tanggal_berakhir)
                    <div class="d-flex align-items-center">
                        <i class="ti ti-clock me-2"></i>
                        Berlaku sampai: {{ \Carbon\Carbon::parse($pengumuman->tanggal_berakhir)->translatedFormat('d F Y') }}
                    </div>
                    @else
                    <div class="d-flex align-items-center">
                        <i class="ti ti-infinity me-2"></i>
                        Berlaku tanpa batas waktu
                    </div>
                    @endif
                </div>

                <p class="fs-5 lh-lg" style="text-align: justify;">
                    {!! nl2br(e($pengumuman->isi)) !!}
                </p>

            </div>

            <div class="card-footer bg-white border-0 px-4 pb-4 d-flex justify-content-end">
                <a href="{{ route('siswa_perwakilan.pengumuman.index') }}" 
                   class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="ti ti-arrow-left me-1"></i> Kembali
                </a>
            </div>

        </div>

    </div>
</div>

@if ($pengumuman->gambar)
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-transparent border-0 shadow-none">

            <div class="modal-body p-0 d-flex justify-content-center align-items-center" 
                 style="cursor: zoom-out;">

                <img src="{{ asset('storage/' . $pengumuman->gambar) }}" 
                     class="rounded-4 shadow-lg"
                     style="max-height: 88vh; width: auto; object-fit: contain;">
            </div>

        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
    .hover-zoom {
        transition: transform 0.25s ease, filter 0.25s ease;
    }
    .hover-zoom:hover {
        transform: scale(1.03);
        filter: brightness(0.93);
    }
    .modal.fade .modal-dialog {
        transform: scale(0.9);
        transition: all 0.25s ease-out;
    }
    .modal.show .modal-dialog {
        transform: scale(1);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('click', function (e) {
        const modalBody = document.querySelector('#imageModal .modal-body');
        if (e.target === modalBody) {
            const modalInstance = bootstrap.Modal.getInstance(document.getElementById('imageModal'));
            modalInstance.hide();
        }
    });
</script>
@endpush