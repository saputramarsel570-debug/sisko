@extends('layouts.app-siswa_perwakilan')

@section('title', 'Buat Keluhan / Saran')

@section('content')
<div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="mb-3">Kirim Keluhan / Saran</h4>

                <form action="{{ route('siswa_perwakilan.keluhan.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select name="kategori" id="kategori" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="keluhan">Keluhan</option>
                            <option value="saran">Saran</option>
                        </select>
                        @error('kategori')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="isi" class="form-label">Isi Keluhan / Saran</label>
                        <textarea name="isi" id="isi" rows="4" class="form-control" required>{{ old('isi') }}</textarea>
                        @error('isi')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Kirim</button>
                    <a href="{{ route('siswa_perwakilan.keluhan.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection