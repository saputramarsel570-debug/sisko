@extends('layouts.app')

@section('title', 'Tambah Pengumuman')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="ti ti-megaphone"></i> Tambah Pengumuman</h4>
            </div>
            <div class="card-body bg-white rounded-bottom-4">
                <form action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                
                    {{-- Judul --}}
                    <div class="mb-3">
                        <label for="judul" class="form-label fw-semibold text-primary">Judul</label>
                        <input type="text" name="judul" id="judul" 
                               class="form-control form-control-lg border-primary-subtle shadow-sm @error('judul') is-invalid @enderror" 
                               value="{{ old('judul') }}" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                
                    {{-- Isi --}}
                    <div class="mb-3">
                        <label for="isi" class="form-label fw-semibold text-primary">Isi Pengumuman</label>
                        <textarea name="isi" id="isi" rows="5" 
                                  class="form-control border-primary-subtle shadow-sm @error('isi') is-invalid @enderror" 
                                  required>{{ old('isi') }}</textarea>
                        @error('isi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                
                    {{-- Gambar --}}
                    <div class="mb-3">
                        <label for="gambar" class="form-label fw-semibold text-primary">Gambar (opsional)</label>
                        <input type="file" class="form-control @error('gambar') is-invalid @enderror" name="gambar" accept="image/*">
                        
                        @error('gambar')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                
                        @if(isset($pengumuman) && $pengumuman->gambar)
                            <div class="mt-2">
                                <img src="{{ asset('uploads/pengumuman/'.$pengumuman->gambar) }}" 
                                     alt="Gambar" class="img-fluid rounded" width="200">
                            </div>
                        @endif
                    </div>
                
                    {{-- Target --}}
                    <div class="mb-4">
                        <label for="target" class="form-label fw-semibold text-primary">Target Audiens</label>
                        <select name="target" id="target" 
                                class="form-select border-primary-subtle shadow-sm @error('target') is-invalid @enderror">
                            <option value="siswa" {{ old('target') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                            <option value="orangtua" {{ old('target') == 'orangtua' ? 'selected' : '' }}>Orang Tua</option>
                            <option value="semua" {{ old('target') == 'semua' ? 'selected' : '' }}>Semua</option>
                        </select>
                        @error('target')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                
                    {{-- Tanggal Berakhir --}}
                    <div class="mb-4">
                        <label for="tanggal_berakhir" class="form-label fw-semibold text-primary">Tanggal Berakhir Pengumuman</label>
                        <input type="date" name="tanggal_berakhir" id="tanggal_berakhir" 
                               class="form-control border-primary-subtle shadow-sm @error('tanggal_berakhir') is-invalid @enderror"
                               value="{{ old('tanggal_berakhir') }}">
                        <small class="text-muted">Biarkan kosong jika pengumuman berlaku tanpa batas waktu.</small>
                
                        @error('tanggal_berakhir')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.25) !important;
    }
</style>
@endpush