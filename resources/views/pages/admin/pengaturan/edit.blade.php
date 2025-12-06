@extends('layouts.app')

@section('title', 'Edit Pengaturan Sekolah')

@section('content')
<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-warning text-dark rounded-top-4">
                <h4 class="mb-0 fw-bold">
                    <i class="ti ti-edit me-2"></i> Edit Pengaturan Sekolah
                </h4>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.pengaturan.update', $pengaturan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label"><i class="ti ti-building"></i> Nama Sekolah</label>
                            <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah', $pengaturan->nama_sekolah) }}"
                                   class="form-control @error('nama_sekolah') is-invalid @enderror" required>
                            @error('nama_sekolah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="ti ti-barcode"></i> NPSN</label>
                            <input type="text" name="npsn" value="{{ old('npsn', $pengaturan->npsn) }}"
                                   class="form-control @error('npsn') is-invalid @enderror">
                            @error('npsn') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="ti ti-school"></i> Jenjang</label>
                            <input type="text" name="jenjang" value="{{ old('jenjang', $pengaturan->jenjang) }}"
                                   class="form-control @error('jenjang') is-invalid @enderror">
                            @error('jenjang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="ti ti-map-pin"></i> Alamat</label>
                            <input type="text" name="alamat" value="{{ old('alamat', $pengaturan->alamat) }}"
                                   class="form-control @error('alamat') is-invalid @enderror">
                            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="ti ti-phone"></i> Telepon</label>
                            <input type="text" name="telepon" value="{{ old('telepon', $pengaturan->telepon) }}"
                                   class="form-control @error('telepon') is-invalid @enderror">
                            @error('telepon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="ti ti-mail"></i> Email</label>
                            <input type="email" name="email" value="{{ old('email', $pengaturan->email) }}"
                                   class="form-control @error('email') is-invalid @enderror">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="ti ti-user"></i> Kepala Sekolah</label>
                            <input type="text" name="kepala_sekolah" value="{{ old('kepala_sekolah', $pengaturan->kepala_sekolah) }}"
                                   class="form-control @error('kepala_sekolah') is-invalid @enderror">
                            @error('kepala_sekolah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="ti ti-id-badge"></i> NIP Kepala Sekolah</label>
                            <input type="text" name="nip_kepala_sekolah" value="{{ old('nip_kepala_sekolah', $pengaturan->nip_kepala_sekolah) }}"
                                   class="form-control @error('nip_kepala_sekolah') is-invalid @enderror">
                            @error('nip_kepala_sekolah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="ti ti-calendar"></i> Tahun Ajaran</label>
                            <input type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran', $pengaturan->tahun_ajaran) }}"
                                   class="form-control @error('tahun_ajaran') is-invalid @enderror">
                            @error('tahun_ajaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="ti ti-clock"></i> Semester</label>
                            <select name="semester" class="form-select @error('semester') is-invalid @enderror">
                                <option value="ganjil" {{ old('semester',$pengaturan->semester)=='ganjil'?'selected':'' }}>Ganjil</option>
                                <option value="genap" {{ old('semester',$pengaturan->semester)=='genap'?'selected':'' }}>Genap</option>
                            </select>
                            @error('semester') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label"><i class="ti ti-photo"></i> Logo Sekolah</label>
                            <input type="file" 
                                   name="logo" 
                                   class="form-control @error('logo') is-invalid @enderror">
                        
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        
                            @if($pengaturan->logo)
                                <small class="text-muted d-block mt-1">Logo saat ini:</small>
                                <img src="{{ asset('storage/'.$pengaturan->logo) }}" 
                                     class="mt-1 rounded border" 
                                     height="60">
                            @endif
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label"><i class="ti ti-file-text"></i> Kop Surat</label>
                            <input type="file" 
                                   name="kop_surat" 
                                   class="form-control @error('kop_surat') is-invalid @enderror">
                        
                            @error('kop_surat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        
                            @if($pengaturan->kop_surat)
                                <small class="text-muted d-block mt-1">Kop saat ini:</small>
                                <img src="{{ asset('storage/'.$pengaturan->kop_surat) }}" 
                                     class="mt-1 rounded border" 
                                     height="60">
                            @endif
                        </div>
                        
                        <div class="col-md-4">
                            <label class="form-label"><i class="ti ti-signature"></i> TTD Kepala Sekolah</label>
                            <input type="file" 
                                   name="ttd_kepsek" 
                                   class="form-control @error('ttd_kepsek') is-invalid @enderror">
                        
                            @error('ttd_kepsek')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        
                            @if($pengaturan->ttd_kepsek)
                                <small class="text-muted d-block mt-1">TTD saat ini:</small>
                                <img src="{{ asset('storage/'.$pengaturan->ttd_kepsek) }}" 
                                     class="mt-1 rounded border" 
                                     height="60">
                            @endif
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.pengaturan.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="ti ti-device-floppy"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
