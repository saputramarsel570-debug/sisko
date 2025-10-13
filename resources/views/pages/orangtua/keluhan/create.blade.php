@extends('layouts.app-orangtua')

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
                {{-- Form sudah pakai enctype untuk upload gambar --}}
                <form action="{{ route('orangtua.keluhan.store') }}" 
                      method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Pilihan kategori --}}
                    <div class="mb-3">
                        <label for="kategori" class="form-label fw-semibold">Kategori</label>
                        <select name="kategori" id="kategori" 
                                class="form-select border-2 rounded-3" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="keluhan" {{ old('kategori') == 'keluhan' ? 'selected' : '' }}>Keluhan</option>
                            <option value="saran" {{ old('kategori') == 'saran' ? 'selected' : '' }}>Saran</option>
                        </select>
                        @error('kategori')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Upload gambar (opsional) --}}
                    <div class="mb-3">
                        <label for="gambar" class="form-label fw-semibold">Foto (opsional)</label>
                        <input type="file" name="gambar" id="gambar" class="form-control border-2 rounded-3" accept="image/*">
                        @error('gambar')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                        {{-- Preview foto saat edit (opsional) --}}
                        @if(isset($keluhan) && $keluhan->gambar)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $keluhan->gambar) }}" 
                                     alt="Gambar Keluhan" 
                                     class="img-thumbnail rounded-3 shadow-sm" 
                                     style="max-width: 200px;">
                            </div>
                        @endif
                    </div>

                    {{-- Isi keluhan atau saran --}}
                    <div class="mb-3">
                        <label for="isi" class="form-label fw-semibold">Isi Keluhan / Saran</label>
                        <textarea name="isi" id="isi" rows="4" 
                                  class="form-control border-2 rounded-3" 
                                  placeholder="Tulis isi keluhan atau saran anda..." required>{{ old('isi') }}</textarea>
                        @error('isi')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Tombol aksi --}}
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('orangtua.keluhan.index') }}" class="btn btn-secondary">
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