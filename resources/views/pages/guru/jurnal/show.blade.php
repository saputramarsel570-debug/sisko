@extends('layouts.app') 

@section('title', 'Detail Jurnal Guru')

@section('content')
<div class="container">
    <h3 class="mb-4">Detail Jurnal Guru</h3>

    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label"><strong>Tanggal</strong></label>
                <p>{{ $jurnal->tanggal }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Kelas</strong></label>
                <p>{{ $jurnal->kelas->nama_kelas ?? '-' }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Mata Pelajaran</strong></label>
                <p>{{ $jurnal->mapel }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Materi</strong></label>
                <p>{{ $jurnal->materi }}</p>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Catatan</strong></label>
                <p>{{ $jurnal->catatan ?? '-' }}</p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('guru.jurnal.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('guru.jurnal.edit', $jurnal->id) }}" class="btn btn-warning">
                    <i class="ti ti-pencil"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>
@endsection