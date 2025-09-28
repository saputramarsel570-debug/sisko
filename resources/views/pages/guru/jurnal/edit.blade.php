@extends('layouts.app')

@section('title', 'Edit Jurnal Guru')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Edit Jurnal Guru</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('guru.jurnal.update', $jurnal->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <input type="text" class="form-control" 
                               value="{{ $jurnal->kelas->nama_kelas ?? '-' }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mata Pelajaran</label>
                        <input type="text" class="form-control" 
                               value="{{ $jurnal->mapel ?? '-' }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Materi <span class="text-danger">*</span></label>
                        <input type="text" name="materi" class="form-control @error('materi') is-invalid @enderror" 
                               value="{{ old('materi', $jurnal->materi) }}" required>
                        @error('materi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" rows="3" 
                                  class="form-control @error('catatan') is-invalid @enderror">{{ old('catatan', $jurnal->catatan) }}</textarea>
                        @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('guru.jurnal.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Update Jurnal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection