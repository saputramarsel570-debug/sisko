@extends('layouts.app-siswa')

@section('title', 'Detail Jadwal Ekskul')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-primary text-white rounded-top-4 d-flex align-items-center">
                <i class="ti ti-calendar-event fs-4 me-2"></i>
                <h4 class="mb-0 fw-semibold">Detail Jadwal Ekskul</h4>
            </div>

            <div class="card-body text-dark">

                <div class="mb-3">
                    <h6 class="fw-bold mb-1">Nama Ekstrakurikuler</h6>
                    <div class="p-2 ps-3 border rounded bg-light">
                        {{ $jadwal_ekskul->ekstrakurikuler->nama }}
                    </div>
                </div>

                <div class="mb-3">
                    <h6 class="fw-bold mb-1">Nama Pembina</h6>
                    <div class="p-2 ps-3 border rounded bg-light">
                        {{ $jadwal_ekskul->ekstrakurikuler->nama_pembina ?? '-' }}
                    </div>
                </div>

                <div class="mb-3">
                    <h6 class="fw-bold mb-1">Hari</h6>
                    <div class="p-2 ps-3 border rounded bg-light">
                        @php
                            $hariList = $jadwal_ekskul->hari;
                            if (!is_array($hariList)) {
                                $hariList = json_decode($hariList, true) ?? [];
                            }
                        @endphp
                        @if(!empty($hariList))
                            @foreach($hariList as $h)
                                <span class="badge bg-info text-dark me-1">{{ $h }}</span>
                            @endforeach
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <h6 class="fw-bold mb-1">Deskripsi</h6>
                    <div class="p-2 ps-3 border rounded bg-light">
                        {{ $jadwal_ekskul->ekstrakurikuler->deskripsi ?? '-' }}
                    </div>
                </div>

                @if(!empty($jadwal_ekskul->ekstrakurikuler->foto))
                <div class="mb-3">
                    <h6 class="fw-bold mb-1">Foto</h6>
                    <div class="text-center mt-2">
                        <img src="{{ asset('storage/' . $jadwal_ekskul->ekstrakurikuler->foto) }}"
                             alt="Foto {{ $jadwal_ekskul->ekstrakurikuler->nama }}"
                             class="img-fluid rounded shadow-sm border"
                             style="max-height: 250px; cursor: zoom-in;"
                             data-bs-toggle="modal"
                             data-bs-target="#imageModal"
                             data-src="{{ asset('storage/' . $jadwal_ekskul->ekstrakurikuler->foto) }}">
                    </div>
                </div>
                @endif

            </div>

            <div class="card-footer bg-light text-end rounded-bottom-4">
                <a href="{{ route('siswa.jadwal_ekskul.index') }}" class="btn btn-primary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
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
    // Modal Preview Gambar
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
</script>
@endpush