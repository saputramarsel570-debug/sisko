@extends('layouts.app')

@section('title', 'Edit Pengaturan Sekolah')

@section('content')
<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-warning">
                <h5 class="mb-0"><i class="ti ti-edit me-2"></i> Edit Pengaturan Sekolah</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pengaturan.update', $pengaturan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Nama Sekolah</label>
                            <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah', $pengaturan->nama_sekolah) }}" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>NPSN</label>
                            <input type="text" name="npsn" value="{{ old('npsn', $pengaturan->npsn) }}" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Jenjang</label>
                            <input type="text" name="jenjang" value="{{ old('jenjang', $pengaturan->jenjang) }}" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Alamat</label>
                            <input type="text" name="alamat" value="{{ old('alamat', $pengaturan->alamat) }}" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Telepon</label>
                            <input type="text" name="telepon" value="{{ old('telepon', $pengaturan->telepon) }}" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ old('email', $pengaturan->email) }}" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Kepala Sekolah</label>
                            <input type="text" name="kepala_sekolah" value="{{ old('kepala_sekolah', $pengaturan->kepala_sekolah) }}" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>NIP Kepala Sekolah</label>
                            <input type="text" name="nip_kepala_sekolah" value="{{ old('nip_kepala_sekolah', $pengaturan->nip_kepala_sekolah) }}" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Tahun Ajaran</label>
                            <input type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran', $pengaturan->tahun_ajaran) }}" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Semester</label>
                            <select name="semester" class="form-select">
                                <option value="ganjil" {{ old('semester',$pengaturan->semester)=='ganjil'?'selected':'' }}>Ganjil</option>
                                <option value="genap" {{ old('semester',$pengaturan->semester)=='genap'?'selected':'' }}>Genap</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Logo Sekolah</label>
                            <input type="file" name="logo" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Kop Surat</label>
                            <input type="file" name="kop_surat" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>TTD Kepala Sekolah</label>
                            <input type="file" name="ttd_kepsek" class="form-control">
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-success">
                            <i class="ti ti-device-floppy"></i> Simpan
                        </button>
                        <a href="{{ route('admin.pengaturan.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
