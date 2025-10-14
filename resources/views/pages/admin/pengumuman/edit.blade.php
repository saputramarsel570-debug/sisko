@extends('layouts.app')

@section('title', 'Edit Pengumuman')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="ti ti-edit"></i> Edit Pengumuman</h4>
            </div>

            <div class="card-body bg-white rounded-bottom-4">
                <form action="{{ route('admin.pengumuman.update', $pengumuman->id) }}" 
                      method="POST" 
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="judul" class="form-label fw-semibold text-primary">Judul</label>
                        <input type="text" name="judul" id="judul" 
                               class="form-control form-control-lg border-primary-subtle shadow-sm" 
                               value="{{ old('judul', $pengumuman->judul) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="isi" class="form-label fw-semibold text-primary">Isi Pengumuman</label>
                        <textarea name="isi" id="isi" rows="5" 
                                  class="form-control border-primary-subtle shadow-sm" 
                                  required>{{ old('isi', $pengumuman->isi) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="target" class="form-label fw-semibold text-primary">Target Audiens</label>
                        <select name="target" id="target" class="form-select border-primary-subtle shadow-sm">
                            <option value="siswa" {{ old('target', $pengumuman->target) == 'siswa' ? 'selected' : '' }}>Siswa</option>
                            <option value="orangtua" {{ old('target', $pengumuman->target) == 'orangtua' ? 'selected' : '' }}>Orang Tua</option>
                            <option value="semua" {{ old('target', $pengumuman->target) == 'semua' ? 'selected' : '' }}>Semua</option>
                        </select>
                    </div>

                    {{-- 🔹 Tambahan: Upload dan preview gambar --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-primary">Gambar Pengumuman (opsional)</label>
                        
                        {{-- Preview gambar lama --}}
                        @if($pengumuman->gambar)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $pengumuman->gambar) }}" 
                                     alt="Gambar Pengumuman" 
                                     class="img-thumbnail" 
                                     style="max-width: 250px; height: auto;">
                            </div>
                        @endif

                        <input type="file" name="gambar" class="form-control border-primary-subtle shadow-sm" accept="image/*">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-outline-secondary me-2">
                            <i class="ti ti-x"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary shadow-sm">
                            <i class="ti ti-device-floppy"></i> Simpan Perubahan
                        </button>
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