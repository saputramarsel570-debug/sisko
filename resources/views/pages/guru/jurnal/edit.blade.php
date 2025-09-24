@extends('layouts.app')

@section('title', 'Edit Jurnal')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Edit Jurnal</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('guru.jurnal.update', $jurnal->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Tanggal</label>
                <input type="date" class="form-control" value="{{ $jurnal->tanggal }}" disabled>
                <input type="hidden" name="tanggal" value="{{ $jurnal->tanggal }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Kelas</label>
                <input type="text" class="form-control" value="{{ $jurnal->kelas->nama ?? '-' }}" disabled>
                <input type="hidden" name="kelas_id" value="{{ $jurnal->kelas_id }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Mata Pelajaran</label>
                <input type="text" class="form-control" value="{{ $jurnal->mapel }}" disabled>
                <input type="hidden" name="mapel" value="{{ $jurnal->mapel }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Materi</label>
                <input type="text" name="materi" class="form-control" value="{{ old('materi', $jurnal->materi) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Catatan</label>
                <textarea name="catatan" class="form-control" rows="3">{{ old('catatan', $jurnal->catatan) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('guru.jurnal.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection