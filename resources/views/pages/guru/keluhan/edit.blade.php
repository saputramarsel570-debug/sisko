@extends('layouts.app')

@section('title', 'Edit Keluhan & Saran')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="page-title">Edit Keluhan & Saran</h3>

        <div class="card border-0 shadow-sm rounded-3 p-4">
            <form action="{{ route('guru.keluhan.update', $keluhan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="fw-bold">Pengirim</label>
                    <div class="p-3 border rounded bg-light">
                        {{ $keluhan->user->name ?? '-' }}
                    </div>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Kategori</label>
                    <div class="p-3 border rounded bg-light">
                        {{ ucfirst($keluhan->kategori) }}
                    </div>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Isi</label>
                    <div class="p-3 border rounded bg-light">
                        {{ $keluhan->isi }}
                    </div>
                </div>

                <div class="mb-3">
                    <label for="status" class="fw-bold">Status</label>
                    <select name="status" id="status" class="form-select border-2 rounded-3">
                        <option value="pending" {{ $keluhan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="proses" {{ $keluhan->status == 'proses' ? 'selected' : '' }}>Proses</option>
                        <option value="selesai" {{ $keluhan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="balasan" class="fw-bold">Balasan</label>
                    <textarea name="balasan" id="balasan" rows="4" class="form-control border-2 rounded-3">{{ old('balasan', $keluhan->balasan) }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('guru.keluhan.index') }}" class="btn btn-secondary">
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