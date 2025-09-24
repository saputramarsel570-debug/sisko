@extends('layouts.app')

@section('title', 'Edit Kegiatan Kalender Akademik')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h3 class="page-title">Edit Kegiatan Kalender Akademik</h3>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.kalender_akademik.update', $kalender->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-3">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" name="judul" id="judul"
                               class="form-control @error('judul') is-invalid @enderror"
                               value="{{ old('judul', $kalender->judul) }}" required>
                        @error('judul')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="jenis" class="form-label">Jenis</label>
                        <select name="jenis" id="jenis"
                                class="form-control @error('jenis') is-invalid @enderror" required>
                            <option value="">-- Pilih Jenis --</option>
                            @foreach(['ujian' => 'Ujian', 'rapat' => 'Rapat', 'kegiatan' => 'Kegiatan Sekolah', 'libur' => 'Libur Nasional'] as $key => $val)
                                <option value="{{ $key }}" {{ old('jenis', $kalender->jenis) == $key ? 'selected' : '' }}>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                        @error('jenis')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai"
                               class="form-control @error('tanggal_mulai') is-invalid @enderror"
                               value="{{ old('tanggal_mulai', $kalender->tanggal_mulai) }}" required>
                        @error('tanggal_mulai')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                               class="form-control @error('tanggal_selesai') is-invalid @enderror"
                               value="{{ old('tanggal_selesai', $kalender->tanggal_selesai) }}" required>
                        @error('tanggal_selesai')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4"
                                  class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $kalender->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-send me-1"></i> Update
                        </button>
                        <a href="{{ route('admin.kalender_akademik.index') }}" class="btn btn-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
