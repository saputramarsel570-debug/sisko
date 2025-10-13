@extends('layouts.app-orangtua')

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
                             class="img-fluid rounded shadow-sm border" style="max-height: 250px;">
                    </div>
                </div>
                @endif

            </div>

            <div class="card-footer bg-light text-end rounded-bottom-4">
                <a href="{{ route('orangtua.jadwal_ekskul.index') }}" class="btn btn-primary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

    </div>
</div>
@endsection