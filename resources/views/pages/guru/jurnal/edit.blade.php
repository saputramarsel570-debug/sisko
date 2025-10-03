@extends('layouts.app-guru')

@section('content')
<div class="container">
    <h3>Edit Jurnal</h3>

    <form action="{{ route('guru.jurnal.update', $jurnal->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Kelas</label>
            <input type="text" class="form-control" value="{{ $jurnal->kelas->nama_kelas }}" disabled>
        </div>

        <div class="mb-3">
            <label>Mapel</label>
            <input type="text" class="form-control" value="{{ $jurnal->mapel->nama_mapel }}" disabled>
        </div>

        <div class="mb-3">
            <label>Tanggal</label>
            <input type="text" class="form-control" value="{{ $jurnal->tanggal }}" disabled>
        </div>

        <div class="mb-3">
            <label>Jam</label>
            <input type="text" class="form-control" value="{{ $jurnal->jam_mulai }} - {{ $jurnal->jam_selesai }}" disabled>
        </div>

        <div class="mb-3">
            <label>Materi</label>
            <textarea name="materi" class="form-control" required>{{ $jurnal->materi }}</textarea>
        </div>

        <div class="mb-3">
            <label>Catatan</label>
            <textarea name="catatan" class="form-control">{{ $jurnal->catatan }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('guru.jurnal.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection