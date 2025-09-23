@extends('layouts.app')

@section('title', 'Tambah Ekstrakurikuler')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h3 class="page-title">Tambah Ekstrakurikuler</h3>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.ekskul.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="nama" class="form-label">Nama Ekstrakurikuler</label>
                        <input type="text" name="nama" id="nama"
                               class="form-control @error('nama') is-invalid @enderror"
                               value="{{ old('nama') }}" required>
                        @error('nama')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="nama_pembina" class="form-label">Nama Pembina</label>
                        <input type="text" name="nama_pembina" id="nama_pembina"
                               class="form-control @error('nama_pembina') is-invalid @enderror"
                               value="{{ old('nama_pembina') }}">
                        @error('nama_pembina')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi"
                                  class="form-control @error('deskripsi') is-invalid @enderror"
                                  rows="4">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="foto" class="form-label">Foto Ekstrakurikuler</label>
                        <input type="file" name="foto" id="foto"
                               class="form-control @error('foto') is-invalid @enderror"
                               accept="image/*">
                        @error('foto')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex">
                        <button type="submit" class="btn btn-primary">
                            <span class="ti ti-send me-1"></span> Simpan
                        </button>
                        <a href="{{ route('admin.ekskul.index') }}" class="btn btn-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
