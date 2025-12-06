@extends('layouts.app-orangtua')

@section('title', 'Detail Jadwal Ekskul')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">

            <div class="card-header bg-primary bg-gradient text-white py-3 d-flex align-items-center">
                <i class="ti ti-calendar-event fs-3 me-2"></i>
                <h4 class="mb-0 fw-semibold">Detail Jadwal Ekskul</h4>
            </div>

            <div class="card-body p-4">

                <div class="info-box mb-3">
                    <label class="info-title">Nama Ekstrakurikuler</label>
                    <div class="info-value">
                        <i class="ti ti-star text-primary me-1"></i>
                        {{ $jadwal_ekskul->ekstrakurikuler->nama }}
                    </div>
                </div>

                <div class="info-box mb-3">
                    <label class="info-title">Nama Pembina</label>
                    <div class="info-value">
                        <i class="ti ti-user-heart text-primary me-1"></i>
                        {{ $jadwal_ekskul->ekstrakurikuler->nama_pembina ?? '-' }}
                    </div>
                </div>

                <div class="info-box mb-3">
                    <label class="info-title">Hari</label>
                    <div class="info-value">
                        @php
                            $hariList = $jadwal_ekskul->hari;
                            if (!is_array($hariList)) {
                                $hariList = json_decode($hariList, true) ?? [];
                            }
                        @endphp

                        @if(!empty($hariList))
                            @foreach($hariList as $h)
                                <span class="badge bg-hari rounded-pill me-1 mb-1">
                                    <i class="ti ti-calendar-event me-1"></i> {{ $h }}
                                </span>
                            @endforeach
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </div>
                </div>

                <div class="info-box mb-3">
                    <label class="info-title">Deskripsi</label>
                    <div class="info-value">
                        {{ $jadwal_ekskul->ekstrakurikuler->deskripsi ?? '-' }}
                    </div>
                </div>

                @if(!empty($jadwal_ekskul->ekstrakurikuler->foto))
                <div class="info-box mb-3">
                    <label class="info-title">Foto</label>
                    <div class="text-center mt-2">
                        <img src="{{ asset('storage/' . $jadwal_ekskul->ekstrakurikuler->foto) }}"
                             alt="Foto {{ $jadwal_ekskul->ekstrakurikuler->nama }}"
                             class="img-fluid rounded-4 shadow-sm border"
                             style="max-height: 260px; cursor: zoom-in;"
                             data-bs-toggle="modal"
                             data-bs-target="#imageModal"
                             data-src="{{ asset('storage/' . $jadwal_ekskul->ekstrakurikuler->foto) }}">
                    </div>
                </div>
                @endif

            </div>

            <div class="card-footer bg-light text-end py-3">
                <a href="{{ route('orangtua.jadwal_ekskul.index') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="ti ti-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="imageModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content bg-transparent border-0 shadow-none">
      <div class="modal-body p-0 d-flex justify-content-center align-items-center" style="cursor: zoom-out;">
        <img id="previewImage" src="" class="rounded-4 shadow-lg"
             style="max-height: 90vh; width: auto; object-fit: contain;">
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
    .info-box {
        background: #f8f9fa;
        border: 1px solid #e6e6e6;
        border-radius: 10px;
        padding: 14px 18px;
    }
    .info-title {
        font-weight: 600;
        color: #6c757d;
        font-size: 14px;
        margin-bottom: 3px;
        display: inline-block;
    }
    .info-value {
        font-size: 16px;
        font-weight: 500;
        color: #333;
    }

    .bg-hari {
        background: #eaf4ff !important;
        color: #0d6efd !important;
        border: 1px solid #b3d7ff !important;
        font-size: 13px;
        padding: 7px 12px;
    }
</style>
@endpush

@push('scripts')
<script>
    const imageModal = document.getElementById('imageModal');
    imageModal.addEventListener('show.bs.modal', event => {
        const trigger = event.relatedTarget;
        document.getElementById('previewImage').src = trigger.dataset.src;
    });

    document.addEventListener('click', function(e) {
        const modalBody = document.querySelector('#imageModal .modal-body');
        if (e.target === modalBody) {
            const modal = bootstrap.Modal.getInstance(imageModal);
            modal.hide();
        }
    });
</script>
@endpush