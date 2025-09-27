@extends('layouts.app')

@section('title', 'Tambah Jurnal Guru')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Tambah Jurnal</h4>
        <a href="{{ route('guru.jurnal.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
    </div>

    <div class="card-body">
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if(session('info'))
            <div class="alert alert-info">{{ session('info') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('guru.jurnal.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="jadwal_id" class="form-label">Pilih Jadwal (kelas & mapel)</label>
                <select name="jadwal_id" id="jadwal_id" class="form-select" required>
                    <option value="">-- Pilih Jadwal --</option>
                    @foreach($jadwal as $j)
                        <option value="{{ $j->id }}"
                                data-kelas="{{ $j->kelas->nama_kelas ?? '' }}"
                                data-mapel="{{ optional($j->mataPelajaran)->nama_mapel ?? '' }}"
                                {{ old('jadwal_id') == $j->id ? 'selected' : '' }}>
                            {{ $j->kelas->nama_kelas ?? 'N/A' }} — {{ optional($j->mataPelajaran)->nama_mapel ?? 'N/A' }}
                            @if(!empty($j->hari))
                                ({{ $j->hari }} {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') ?? '' }})
                            @endif
                        </option>
                    @endforeach
                </select>
                @error('jadwal_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="row g-2 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Kelas</label>
                    <input type="text" id="display_kelas" class="form-control" value="{{ old('display_kelas') }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Mata Pelajaran</label>
                    <input type="text" id="display_mapel" class="form-control" value="{{ old('display_mapel') }}" readonly>
                </div>
            </div>

            <div class="mb-3">
                <label for="materi" class="form-label">Materi</label>
                <input type="text" name="materi" id="materi" class="form-control" value="{{ old('materi') }}" required>
                @error('materi') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="catatan" class="form-label">Catatan</label>
                <textarea name="catatan" id="catatan" rows="4" class="form-control">{{ old('catatan') }}</textarea>
                @error('catatan') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('guru.jurnal.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection