@extends('layouts.app')

@section('title', 'Tambah Jadwal Ekskul')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h3 class="page-title">Tambah Jadwal Ekskul</h3>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.jadwal_ekskul.store') }}" method="POST">
                    @csrf

                    <div class="form-group mb-3">
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

                    <div class="form-group mb-3">
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

                    <div class="flex mt-3">
                        <button type="submit" class="btn btn-primary">
                            <span class="ti ti-send me-1"></span> Simpan
                        </button>
                        <a href="{{ route('admin.jadwal_ekskul.index') }}" class="btn btn-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection