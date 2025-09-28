@extends('layouts.app')

@section('title', 'Detail Jurnal Guru')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Detail Jurnal Guru</h5>
                <a href="{{ route('guru.jurnal.index') }}" class="btn btn-sm btn-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Tanggal</dt>
                    <dd class="col-sm-8">{{ \Carbon\Carbon::parse($jurnal->tanggal)->translatedFormat('l, d F Y') }}</dd>

                    <dt class="col-sm-4">Kelas</dt>
                    <dd class="col-sm-8">{{ $jurnal->kelas->nama_kelas ?? '-' }}</dd>

                    <dt class="col-sm-4">Mata Pelajaran</dt>
                    <dd class="col-sm-8">{{ $jurnal->mapel ?? '-' }}</dd>

                    <dt class="col-sm-4">Materi</dt>
                    <dd class="col-sm-8">{{ $jurnal->materi }}</dd>

                    <dt class="col-sm-4">Catatan</dt>
                    <dd class="col-sm-8">{{ $jurnal->catatan ?? '-' }}</dd>

                    <dt class="col-sm-4">Guru Pembuat</dt>
                    <dd class="col-sm-8">{{ $jurnal->guru->nama ?? '-' }}</dd>

                    <dt class="col-sm-4">Dibuat pada</dt>
                    <dd class="col-sm-8">{{ $jurnal->created_at->translatedFormat('d F Y H:i') }}</dd>

                    <dt class="col-sm-4">Terakhir diupdate</dt>
                    <dd class="col-sm-8">{{ $jurnal->updated_at->translatedFormat('d F Y H:i') }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection