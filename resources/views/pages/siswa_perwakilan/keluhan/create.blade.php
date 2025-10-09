@extends('layouts.app-siswa_perwakilan')

@section('title', 'Buat Keluhan / Saran')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-primary text-white rounded-top-4 d-flex align-items-center justify-content-between">
                <h4 class="mb-0 fw-semibold">
                    <i class="ti ti-message-plus me-2"></i> Buat Keluhan / Saran
                </h4>
            </div>
            <div class="card-body text-black">
                <form action="{{ route('siswa_perwakilan.keluhan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="kategori" class="form-label fw-semibold">Kategori</label>
                        <select name="kategori" id="kategori" class="form-select border-2 rounded-3" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="keluhan" {{ old('kategori') == 'keluhan' ? 'selected' : '' }}>Keluhan</option>
                            <option value="saran" {{ old('kategori') == 'saran' ? 'selected' : '' }}>Saran</option>
                        </select>
                        @error('kategori')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="isi" class="form-label fw-semibold">Isi Keluhan / Saran</label>
                        <textarea name="isi" id="isi" rows="4" class="form-control border-2 rounded-3" placeholder="Tulis isi keluhan atau saran anda..." required>{{ old('isi') }}</textarea>
                        @error('isi')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('siswa_perwakilan.keluhan.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-send"></i> Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection