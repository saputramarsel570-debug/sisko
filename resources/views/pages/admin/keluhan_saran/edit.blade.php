@extends('layouts.app')

@section('title', 'Edit Keluhan & Saran')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">
                    <i class="ti ti-edit me-2"></i> Edit Keluhan & Saran
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.keluhan_saran.update', $keluhan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="fw-semibold text-secondary">Pengirim</label>
                        <div class="p-3 border rounded bg-body-tertiary">
                            {{ $keluhan->user->name ?? '-' }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold text-secondary">Kategori</label>
                        <div class="p-3 border rounded bg-body-tertiary">
                            {{ ucfirst($keluhan->kategori) }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="fw-semibold text-secondary">Isi</label>
                        <div class="p-3 border rounded bg-body-tertiary">
                            {{ $keluhan->isi }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="fw-semibold text-secondary">Status</label>
                        <select name="status" id="status" class="form-select border-2 rounded-3">
                            <option value="pending" {{ $keluhan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="proses" {{ $keluhan->status == 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ $keluhan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="balasan" class="fw-semibold text-secondary">Balasan</label>
                        <textarea name="balasan" id="balasan" rows="4" class="form-control border-2 rounded-3">{{ old('balasan', $keluhan->balasan) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.keluhan_saran.index') }}" class="btn btn-secondary">
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