@extends('layouts.app')

@section('title', 'Tambah Jurnal')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">Tambah Jurnal</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('guru.jurnal.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Kelas</label>
                <input type="text" class="form-control" value="{{ $kelas }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Mata Pelajaran</label>
                <input type="text" class="form-control" value="{{ $mapel }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Materi</label>
                <input type="text" name="materi" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Catatan</label>
                <textarea name="catatan" class="form-control" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection