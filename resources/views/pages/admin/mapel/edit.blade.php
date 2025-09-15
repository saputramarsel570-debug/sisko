@extends('layouts.app')

@section('title', 'Edit Mata Pelajaran')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h3 class="page-title mb-3">Edit Mata Pelajaran</h3>

            <div class="card card-body">
                <form action="{{ route('admin.mapel.update', $mapel->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label for="kode_mapel" class="form-label">Kode Mapel</label>
                        <input type="text" name="kode_mapel" id="kode_mapel"
                               class="form-control @error('kode_mapel') is-invalid @enderror"
                               value="{{ old('kode_mapel', $mapel->kode_mapel) }}" required>
                        @error('kode_mapel')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="nama_mapel" class="form-label">Nama Mapel</label>
                        <input type="text" name="nama_mapel" id="nama_mapel"
                               class="form-control @error('nama_mapel') is-invalid @enderror"
                               value="{{ old('nama_mapel', $mapel->nama_mapel) }}" required>
                        @error('nama_mapel')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="flex">
                        <button type="submit" class="btn btn-primary">
                            <span class="ti ti-send me-1"></span> Update
                        </button>
                        <a href="{{ route('admin.mapel.index') }}" class="btn btn-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
