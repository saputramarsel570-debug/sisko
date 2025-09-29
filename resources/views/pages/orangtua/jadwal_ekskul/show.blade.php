@extends('layouts.app')

@section('title', 'Detail Jadwal Ekskul')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h3 class="page-title mb-3">Detail Jadwal Ekskul</h3>

        <div class="card card-body">
            <div class="mb-3">
                <h5 class="fw-bold">Nama Ekstrakurikuler</h5>
                <p>{{ $jadwal_ekskul->ekstrakurikuler->nama }}</p>
            </div>

            <div class="mb-3">
                <h5 class="fw-bold">Nama Pembina</h5>
                <p>{{ $jadwal_ekskul->ekstrakurikuler->nama_pembina ?? '-' }}</p>
            </div>

            <div class="mb-3">
                <h5 class="fw-bold">Hari</h5>
                @php
                    $hariList = $jadwal_ekskul->hari;
                    if (!is_array($hariList)) {
                        $hariList = json_decode($hariList, true) ?? [];
                    }
                @endphp
                <p>
                    @if(!empty($hariList))
                        {{ implode(', ', $hariList) }}
                    @else
                        -
                    @endif
                </p>
            </div>

            <div class="mb-3">
                <h5 class="fw-bold">Deskripsi</h5>
                <p>{{ $jadwal_ekskul->ekstrakurikuler->deskripsi ?? '-' }}</p>
            </div>

            @if(!empty($jadwal_ekskul->ekstrakurikuler->foto))
                <div class="mb-3">
                    <h5 class="fw-bold">Foto</h5>
                    <img src="{{ asset('storage/' . $jadwal_ekskul->ekstrakurikuler->foto) }}"
                         alt="Foto {{ $jadwal_ekskul->ekstrakurikuler->nama }}"
                         class="img-fluid rounded" style="max-height: 250px;">
                </div>
            @endif

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('orangtua.jadwal_ekskul.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection