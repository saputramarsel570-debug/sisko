@extends('layouts.app')

@section('title', 'Edit Keluhan & Saran')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h3 class="page-title">Edit Keluhan & Saran</h3>

            <div class="card card-body">
                <form action="{{ route('admin.keluhan_saran.update', $keluhanSaran->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label class="form-label">Pengirim</label>
                        <input type="text" class="form-control" value="{{ $keluhanSaran->user->name ?? '-' }}" disabled>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" class="form-control" value="{{ ucfirst($keluhanSaran->kategori) }}" disabled>
                    </div>
                    <div class="form-group mb-3">
                        <label for="isi" class="form-label">Isi</label>
                        <textarea name="isi" id="isi" class="form-control" rows="4" disabled>{{ $keluhanSaran->isi }}</textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="pending" {{ $keluhanSaran->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="proses" {{ $keluhanSaran->status == 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ $keluhanSaran->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.keluhan_saran.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
