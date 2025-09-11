@extends('layouts.app')

@section('title', 'Tambah Keluhan & Saran')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <h3 class="page-title">Tambah Keluhan & Saran</h3>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('siswa.keluhan.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select name="kategori" id="kategori"
                                class="form-control @error('kategori') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Keluhan" {{ old('kategori') == 'Keluhan' ? 'selected' : '' }}>Keluhan</option>
                                <option value="Saran" {{ old('kategori') == 'Saran' ? 'selected' : '' }}>Saran</option>
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="isi" class="form-label">Isi</label>
                            <textarea class="form-control @error('isi') is-invalid @enderror" id="isi" name="isi" rows="4"
                                placeholder="Tuliskan keluhan atau saran..." required>{{ old('isi') }}</textarea>
                            @error('isi')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="flex">
                            <button type="submit" class="btn btn-primary">
                                <span class="ti ti-send me-1"></span>
                                Simpan
                            </button>

                            <a href="{{ route('siswa.keluhan.index') }}" class="btn btn-secondary">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection