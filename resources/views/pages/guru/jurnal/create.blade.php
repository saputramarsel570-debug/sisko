@extends('layouts.app')

@section('title', 'Tambah Jurnal Guru')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Tambah Jurnal Guru</h4>
            </div>
            <div class="card-body">
                
                @if(!$jadwal)
                    <div class="alert alert-warning">
                        Tidak ada jadwal mengajar pada hari ini. 
                    </div>
                @endif

                <form action="{{ route('guru.jurnal.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <input type="text" class="form-control" 
                               value="{{ $jadwal->kelas->nama_kelas ?? '-' }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mata Pelajaran</label>
                        <input type="text" class="form-control" 
                               value="{{ $jadwal->mataPelajaran->nama_mapel ?? '-' }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Materi <span class="text-danger">*</span></label>
                        <input type="text" name="materi" class="form-control @error('materi') is-invalid @enderror" 
                               value="{{ old('materi') }}" required>
                        @error('materi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" rows="3" 
                                  class="form-control @error('catatan') is-invalid @enderror">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('guru.jurnal.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Jurnal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection