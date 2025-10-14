@extends('layouts.app-orangtua')

@section('title', 'Pengaturan Sekolah')

@section('content')
<div class="row">
    <div class="col-md-10 offset-md-1">
        @if (session('success'))
            <div id="success" class="alert alert-solid-success d-flex align-items-center" role="alert">
                <span class="alert-icon rounded"><i class="ti ti-check"></i></span>
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold">
                    <i class="ti ti-building me-2"></i> Profil Sekolah
                </h4>
            </div>

            <div class="card-body">
                <div class="row align-items-center mb-4">
                    <div class="col-md-3 text-center">
                        @if($pengaturan->logo)
                            <img src="{{ asset('storage/'.$pengaturan->logo) }}" 
                                 class="rounded border mb-2 mt-3"
                                 height="100" 
                                 alt="Logo Sekolah"
                                 style="cursor: zoom-in;"
                                 data-bs-toggle="modal"
                                 data-bs-target="#imageModal"
                                 data-src="{{ asset('storage/'.$pengaturan->logo) }}">
                        @else
                            <div class="bg-light text-muted d-flex align-items-center justify-content-center rounded mb-2" style="width:100px; height:100px;">
                                <i class="ti ti-building fs-2"></i>
                            </div>
                        @endif
                        <small class="text-muted d-block">Logo Sekolah</small>
                    </div>
                    <div class="col-md-9">
                        <h4 class="fw-bold mb-1">{{ $pengaturan->nama_sekolah }}</h4>
                        <p class="mb-0"><i class="ti ti-barcode"></i> NPSN: <span class="text-muted">{{ $pengaturan->npsn }}</span></p>
                        <p class="mb-0"><i class="ti ti-school"></i> Jenjang: <span class="text-muted">{{ $pengaturan->jenjang }}</span></p>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 border rounded bg-light">
                            <h6 class="fw-bold mb-2"><i class="ti ti-map-pin"></i> Alamat</h6>
                            <p class="mb-0">{{ $pengaturan->alamat }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border rounded bg-light">
                            <h6 class="fw-bold mb-2"><i class="ti ti-phone"></i> Kontak</h6>
                            <p class="mb-1">Telepon: {{ $pengaturan->telepon ?? '-' }}</p>
                            <p class="mb-0">Email: {{ $pengaturan->email ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <div class="p-3 border rounded bg-light">
                            <h6 class="fw-bold mb-2"><i class="ti ti-user"></i> Kepala Sekolah</h6>
                            <p class="mb-1">{{ $pengaturan->kepala_sekolah ?? '-' }}</p>
                            <p class="mb-0 text-muted">NIP: {{ $pengaturan->nip_kepala_sekolah ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 border rounded bg-light">
                            <h6 class="fw-bold mb-2"><i class="ti ti-calendar"></i> Tahun Ajaran & Semester</h6>
                            <p class="mb-1">Tahun Ajaran: {{ $pengaturan->tahun_ajaran }}</p>
                            <p class="mb-0">Semester: {{ ucfirst($pengaturan->semester) }}</p>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mt-3">
                    <div class="col-md-6 text-center">
                        <div class="border rounded p-3">
                            <h6 class="fw-bold mb-2"><i class="ti ti-file-text"></i> Kop Surat</h6>
                            @if($pengaturan->kop_surat)
                                <img src="{{ asset('storage/'.$pengaturan->kop_surat) }}" 
                                     class="rounded border"
                                     height="100"
                                     alt="Kop Surat"
                                     style="cursor: zoom-in;"
                                     data-bs-toggle="modal"
                                     data-bs-target="#imageModal"
                                     data-src="{{ asset('storage/'.$pengaturan->kop_surat) }}">
                            @else
                                <span class="text-muted">Belum diunggah</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="border rounded p-3">
                            <h6 class="fw-bold mb-2"><i class="ti ti-signature"></i> Tanda Tangan Kepala Sekolah</h6>
                            @if($pengaturan->ttd_kepsek)
                                <img src="{{ asset('storage/'.$pengaturan->ttd_kepsek) }}" 
                                     class="rounded border"
                                     height="100"
                                     alt="TTD Kepala Sekolah"
                                     style="cursor: zoom-in;"
                                     data-bs-toggle="modal"
                                     data-bs-target="#imageModal"
                                     data-src="{{ asset('storage/'.$pengaturan->ttd_kepsek) }}">
                            @else
                                <span class="text-muted">Belum diunggah</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Gambar --}}
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-transparent border-0 shadow-none">
      <div class="modal-body p-0 d-flex justify-content-center align-items-center">
        <img id="previewImage" src="" alt="Preview" 
             class="w-100 rounded-4 shadow-lg"
             style="max-height: 85vh; object-fit: contain;">
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
    // --- Modal Preview Gambar ---
    const imageModal = document.getElementById('imageModal');
    imageModal.addEventListener('show.bs.modal', event => {
        const triggerImg = event.relatedTarget;
        const newSrc = triggerImg.getAttribute('data-src');
        const modalImg = document.getElementById('previewImage');
        modalImg.src = newSrc;
    });

    // Tutup modal jika klik area luar gambar
    document.addEventListener('click', function(e) {
        const modalBody = document.querySelector('#imageModal .modal-body');
        if (e.target === modalBody) {
            const modalInstance = bootstrap.Modal.getInstance(document.getElementById('imageModal'));
            modalInstance.hide();
        }
    });

    // --- Notifikasi sukses auto-hilang ---
    setTimeout(function () {
        let alert = document.getElementById('success');
        if (alert) {
            alert.style.transition = "opacity 0.5s ease";
            alert.style.opacity = 0;
            setTimeout(() => alert.remove(), 500);
        }
    }, 3000);
</script>
@endpush