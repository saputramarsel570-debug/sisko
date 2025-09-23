@extends('layouts.app')

@section('title', 'Edit Jadwal Ekskul')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h3 class="page-title mb-3">Edit Jadwal Ekskul</h3>

        <div class="card card-body">
            <form action="{{ route('admin.jadwal_ekskul.update', $jadwal_ekskul->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="ekstrakurikuler_id" class="form-label">Ekskul</label>
                    <select name="ekstrakurikuler_id" id="ekstrakurikuler_id"
                            class="form-control @error('ekstrakurikuler_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Ekskul --</option>
                        @foreach($ekskul as $item)
                            <option value="{{ $item->id }}" 
                                {{ old('ekstrakurikuler_id', $jadwal_ekskul->ekstrakurikuler_id) == $item->id ? 'selected' : '' }}>
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
                        @php
                            $hariTersimpan = old('hari', $jadwal_ekskul->hari ?? []);
                            if (!is_array($hariTersimpan)) {
                                $hariTersimpan = json_decode($hariTersimpan, true) ?? [];
                            }
                        @endphp

                        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $hari)
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="hari[]"
                                       id="hari_{{ $hari }}"
                                       value="{{ $hari }}"
                                       {{ in_array($hari, $hariTersimpan) ? 'checked' : '' }}>
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

                <div class="flex">
                    <button type="submit" class="btn btn-primary">
                        <span class="ti ti-send me-1"></span> Update
                    </button>
                    <a href="{{ route('admin.jadwal_ekskul.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection