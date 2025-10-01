@extends('layouts.app')

@section('title', 'Edit Keluhan & Saran')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-warning text-dark rounded-top-4">
                <h4 class="mb-0 fw-bold"><i class="ti ti-message-circle-edit"></i> Edit Keluhan & Saran</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.keluhan_saran.update', $keluhanSaran->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Pengirim --}}
                    <div class="mb-3">
                        <label class="form-label">Pengirim</label>
                        <input type="text" class="form-control" value="{{ $keluhanSaran->user->name ?? '-' }}" disabled>
                    </div>

                    {{-- Kategori --}}
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" class="form-control" value="{{ ucfirst($keluhanSaran->kategori) }}" disabled>
                    </div>

                    {{-- Isi --}}
                    <div class="mb-3">
                        <label for="isi" class="form-label">Isi</label>
                        <textarea id="isi" class="form-control" rows="4" disabled>{{ $keluhanSaran->isi }}</textarea>
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status"
                                class="form-select @error('status') is-invalid @enderror">
                            <option value="pending" {{ $keluhanSaran->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="proses" {{ $keluhanSaran->status == 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ $keluhanSaran->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        @error('status') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.keluhan_saran.index') }}" class="btn btn-secondary">
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
