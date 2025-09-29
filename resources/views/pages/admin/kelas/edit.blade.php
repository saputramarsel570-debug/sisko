@extends('layouts.app')

@section('title', 'Edit Data Kelas')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-warning text-dark rounded-top-4">
                <h4 class="mb-0 fw-bold"><i class="ti ti-home-edit"></i> Edit Data Kelas</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.kelas.update', $kelas->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Nama Kelas --}}
                    <div class="mb-3">
                        <label for="nama_kelas" class="form-label">Nama Kelas</label>
                        <input type="text" name="nama_kelas" id="nama_kelas"
                               class="form-control @error('nama_kelas') is-invalid @enderror"
                               value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required>
                        @error('nama_kelas') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    {{-- Wali Kelas --}}
                    <div class="mb-3">
                        <label for="wali_kelas_id" class="form-label">Wali Kelas</label>
                        <select name="wali_kelas_id" id="wali_kelas_id"
                                class="form-control @error('wali_kelas_id') is-invalid @enderror">
                            <option value="">-- Pilih Wali Kelas --</option>
                            @foreach ($guru as $g)
                                <option value="{{ $g->id }}" {{ old('wali_kelas_id', $kelas->wali_kelas_id) == $g->id ? 'selected' : '' }}>
                                    {{ $g->nama }} ({{ $g->nip }})
                                </option>
                            @endforeach
                        </select>
                        @error('wali_kelas_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left"></i> Kembali
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
