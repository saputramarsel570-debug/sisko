@extends('layouts.app')

@section('title', 'Edit Pengumuman')

@section('content')
    <div class="row">
        <div class="cpl-md-12">
            <h3 class="page-title">Edit Pengumuman</h3>

            <div class="card card-body">
                <form action="{{ route('guru.pengumuman.update', $pengumuman->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" name="judul" id="judul" 
                                class="form-control @error('judul') is-invalid @enderror" 
                                value="{{ old('judul', $pengumuman->judul) }}" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="isi" class="form-label">isi</label>
                            <textarea name="isi" id="isi" rows="5" 
                                class="form-control @error('isi') is-invalid @enderror" 
                                required>{{ old('isi', $pengumuman->isi) }}</textarea>
                            @error('isi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="target" class="form-label">Target Audiens</label>
                            <select name="target" id="target" class="form-control">
                                <option value="siswa">Siswa</option>
                                <option value="orangtua">Orang Tua</option>
                                <option value="semua">Semua</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('guru.pengumuman.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection