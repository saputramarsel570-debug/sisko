@extends('layouts.app')

@section('title', 'Detail Jadwal Ekskul')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="d-flex align-items-center mb-4">
            <i class="ti ti-calendar-event text-black fs-3 me-2"></i>
            <h3 class="fw-bold text-primary m-0">Detail Jadwal Ekskul</h3>
        </div>
        <div class="accordion shadow-sm rounded" id="accordionDetail">

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingNama">
                    <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNama" aria-expanded="true" aria-controls="collapseNama">
                        Nama Ekstrakurikuler
                    </button>
                </h2>
                <div id="collapseNama" class="accordion-collapse collapse show" aria-labelledby="headingNama" data-bs-parent="#accordionDetail">
                    <div class="accordion-body">
                        {{ $jadwal_ekskul->ekstrakurikuler->nama }}
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingPembina">
                    <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePembina" aria-expanded="false" aria-controls="collapsePembina">
                        Nama Pembina
                    </button>
                </h2>
                <div id="collapsePembina" class="accordion-collapse collapse" aria-labelledby="headingPembina" data-bs-parent="#accordionDetail">
                    <div class="accordion-body">
                        {{ $jadwal_ekskul->ekstrakurikuler->nama_pembina ?? '-' }}
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingHari">
                    <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHari" aria-expanded="false" aria-controls="collapseHari">
                        Hari
                    </button>
                </h2>
                <div id="collapseHari" class="accordion-collapse collapse" aria-labelledby="headingHari" data-bs-parent="#accordionDetail">
                    <div class="accordion-body">
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
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header" id="headingDeskripsi">
                    <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDeskripsi" aria-expanded="false" aria-controls="collapseDeskripsi">
                        Deskripsi
                    </button>
                </h2>
                <div id="collapseDeskripsi" class="accordion-collapse collapse" aria-labelledby="headingDeskripsi" data-bs-parent="#accordionDetail">
                    <div class="accordion-body">
                        {{ $jadwal_ekskul->ekstrakurikuler->deskripsi ?? '-' }}
                    </div>
                </div>
            </div>

            @if(!empty($jadwal_ekskul->ekstrakurikuler->foto))
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFoto">
                    <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFoto" aria-expanded="false" aria-controls="collapseFoto">
                        Foto
                    </button>
                </h2>
                <div id="collapseFoto" class="accordion-collapse collapse" aria-labelledby="headingFoto" data-bs-parent="#accordionDetail">
                    <div class="accordion-body text-center">
                        <img src="{{ asset('storage/' . $jadwal_ekskul->ekstrakurikuler->foto) }}"
                             alt="Foto {{ $jadwal_ekskul->ekstrakurikuler->nama }}"
                             class="img-fluid rounded shadow-sm" style="max-height: 250px;">
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="d-flex justify-content-end mt-4">
            <a href="{{ route('siswa.jadwal_ekskul.index') }}" class="btn btn-primary">
                <i class="ti ti-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection