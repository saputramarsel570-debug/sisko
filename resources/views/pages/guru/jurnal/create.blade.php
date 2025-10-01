@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Tambah Jurnal</h3>
    <p>Hari ini: {{ $hariIni }}</p>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('guru.jurnal.store') }}" method="POST">
        @csrf
        <input type="hidden" name="kelas_id" value="{{ $jadwal->kelas_id }}">
        <input type="hidden" name="mapel_id" value="{{ $jadwal->mata_pelajaran_id }}">
        <input type="hidden" name="guru_id" value="{{ $jadwal->guru_id }}">
        <input type="hidden" name="tanggal" value="{{ now()->toDateString() }}">
        <input type="hidden" name="jam_mulai" value="{{ $jadwal->jam_mulai }}">
        <input type="hidden" name="jam_selesai" value="{{ $jadwal->jam_selesai }}">

        <div class="mb-3">
            <label class="form-label">Kelas</label>
            <input type="text" class="form-control" value="{{ $jadwal->kelas->nama_kelas }}" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Mata Pelajaran</label>
            <input type="text" class="form-control" value="{{ $jadwal->mataPelajaran->nama_mapel }}" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Jam</label>
            <input type="text" class="form-control" value="{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}" readonly>
        </div>

        <div class="mb-3">
            <label for="materi" class="form-label">Materi</label>
            <textarea name="materi" id="materi" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan</label>
            <textarea name="catatan" id="catatan" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('guru.jurnal.index', ['kelas_id' => $kelasId]) }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection