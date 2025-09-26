@extends('layouts.app')

@section('title', 'Edit Ekstrakurikuler')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h3 class="page-title mb-3">Edit Ekstrakurikuler</h3>

        <div class="card card-body">
            <form action="{{ route('admin.ekskul.update', $ekskul->id) }}"
                  method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="nama" class="form-label">Nama Ekstrakurikuler</label>
                    <input type="text" name="nama" id="nama"
                           class="form-control @error('nama') is-invalid @enderror"
                           value="{{ old('nama', $ekskul->nama) }}" required>
                    @error('nama')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="nama_pembina" class="form-label">Nama Pembina</label>
                    <input type="text" name="nama_pembina" id="nama_pembina"
                           class="form-control @error('nama_pembina') is-invalid @enderror"
                           value="{{ old('nama_pembina', $ekskul->nama_pembina) }}">
                    @error('nama_pembina')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi"
                              class="form-control @error('deskripsi') is-invalid @enderror"
                              rows="4">{{ old('deskripsi', $ekskul->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="foto" class="form-label">Foto Ekstrakurikuler</label>
                    @if($ekskul->foto)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $ekskul->foto) }}"
                                 alt="Foto Ekstrakurikuler"
                                 class="img-thumbnail" width="200">
                        </div>
                    @endif
                    <input type="file" name="foto" id="foto"
                           class="form-control @error('foto') is-invalid @enderror"
                           accept="image/*">
                    @error('foto')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                </div>

                <div class="flex">
                    <button type="submit" class="btn btn-primary">
                        <span class="ti ti-send me-1"></span> Update
                    </button>
                    <a href="{{ route('admin.ekskul.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
