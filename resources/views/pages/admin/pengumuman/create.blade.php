@extends('layouts.app')

@section('title', 'Tambah Pengumuman')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="page-title">Tambah Pengumuman</h3>

        <div class="card card-body">
            <form action="{{ route('admin.pengumuman.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul</label>
                    <input type="text" name="judul" id="judul"
                           class="form-control @error('judul') is-invalid @enderror"
                           value="{{ old('judul') }}" required>
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="isi" class="form-label">Isi</label>
                    <textarea name="isi" id="isi" rows="5"
                              class="form-control @error('isi') is-invalid @enderror"
                              required>{{ old('isi') }}</textarea>
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
                    <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
