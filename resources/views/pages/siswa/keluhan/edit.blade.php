@extends('layouts.app-siswa')

@section('title', 'Edit Keluhan & Saran')

@section('content')
<div class="row">
    <div class="col-md-12 offset-md-12">
        <div class="card shadow-sm rounded-3">
            <div class="card-header bg-primary text-white rounded-top-4 d-flex align-items-center">
                <i class="ti ti-message-2 me-2"></i>
                <h4 class="mb-0 fw-semibold">Detail Keluhan & Saran</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('siswa.keluhan.update', $keluhan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3 p-3 border rounded-3 bg-light mt-3">
                        <label class="form-label fw-bold">Kategori</label>
                        <select name="kategori" class="form-select" required>
                            <option value="keluhan" {{ $keluhan->kategori == 'keluhan' ? 'selected' : '' }}>Keluhan</option>
                            <option value="saran" {{ $keluhan->kategori == 'saran' ? 'selected' : '' }}>Saran</option>
                        </select>
                    </div>

                    <div class="mb-3 p-3 border rounded-3 bg-light">
                        <label class="form-label fw-bold">Isi</label>
                        <textarea name="isi" rows="4" class="form-control" required>{{ $keluhan->isi }}</textarea>
                    </div>

                    <div class="d-flex justify-content-start gap-2 mt-3">
                        <a href="{{ route('siswa.keluhan.index') }}" class="btn btn-secondary">
                            <span class="ti ti-arrow-left"></span> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <span class="ti ti-device-floppy"></span> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection