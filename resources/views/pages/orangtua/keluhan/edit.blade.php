@extends('layouts.app')

@section('title', 'Edit Keluhan & Saran')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3 class="page-title">Edit Keluhan & Saran</h3>

            <div class="card shadow-sm">
                <div class="card-body bg-white rounded">
                    <form action="{{ route('orangtua.keluhan.update', $keluhan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <input type="text" class="form-control @error('kategori') is-invalid @enderror"
                                id="kategori" 
                                name="kategori" 
                                value="{{ old('kategori', $keluhan->kategori) }}" />
                            @error('kategori')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="isi" class="form-label">Isi</label>
                            <textarea class="form-control @error('isi') is-invalid @enderror" 
                                    id="isi" 
                                    name="isi" 
                                    rows="5">{{ old('isi', $keluhan->isi) }}</textarea>
                            @error('isi')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="tipe_pengirim" class="form-label">Tipe Pengirim</label>
                            <input type="text" class="form-control" id="tipe_pengirim" value="orangtua" readonly>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mb-3">
                            <a href="{{ route('orangtua.keluhan.index') }}" class="btn btn-secondary">
                                <span class="ti ti-arrow-left me-1"></span> 
                                Kembali
                            </a> 
                            <button type="submit" class="btn btn-primary">
                                <span class="ti ti-send me-1"></span>
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection