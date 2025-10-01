@extends('layouts.app')

@section('title', 'Tambah Jadwal Ekskul')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-primary text-white rounded-top-4">
                <h4 class="mb-0 fw-bold"><i class="ti ti-calendar-plus"></i> Tambah Jadwal Ekskul</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.jadwal_ekskul.store') }}" method="POST">
                    @csrf

                    {{-- Pilih Ekskul --}}
                    <div class="mb-3">
                        <label for="ekstrakurikuler_id" class="form-label">Ekskul</label>
                        <select name="ekstrakurikuler_id" id="ekstrakurikuler_id"
                                class="form-control @error('ekstrakurikuler_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Ekskul --</option>
                            @foreach($ekskul as $item)
                                <option value="{{ $item->id }}" {{ old('ekstrakurikuler_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('ekstrakurikuler_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Pilih Hari --}}
                    <div class="mb-3">
                        <label class="form-label">Hari</label>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="hari[]"
                                           id="hari_{{ $hari }}"
                                           value="{{ $hari }}"
                                           {{ is_array(old('hari')) && in_array($hari, old('hari')) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="hari_{{ $hari }}">
                                        {{ $hari }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('hari')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.jadwal_ekskul.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
