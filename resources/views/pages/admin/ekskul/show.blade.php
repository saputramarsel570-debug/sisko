@extends('layouts.app')

@section('title', 'Detail Ekstrakurikuler')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h3 class="page-title mb-3">Detail Ekstrakurikuler</h3>

        <div class="card card-body">
            <div class="mb-3">
                <h5 class="fw-bold">Nama Ekstrakurikuler</h5>
                <p>{{ $ekskul->nama }}</p>
            </div>

            <div class="mb-3">
                <h5 class="fw-bold">Nama Pembina</h5>
                <p>{{ $ekskul->nama_pembina ?? '-' }}</p>
            </div>

            <div class="mb-3">
                <h5 class="fw-bold">Deskripsi</h5>
                <p>{{ $ekskul->deskripsi ?? '-' }}</p>
            </div>

            @if($ekskul->foto)
                <div class="mb-3">
                    <h5 class="fw-bold">Foto</h5>
                    <img src="{{ asset('storage/' . $ekskul->foto) }}"
                         alt="Foto {{ $ekskul->nama }}"
                         class="img-thumbnail" width="300">
                </div>
            @endif

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.ekskul.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('admin.ekskul.edit', $ekskul->id) }}" class="btn btn-warning">
                    <i class="ti ti-pencil"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
