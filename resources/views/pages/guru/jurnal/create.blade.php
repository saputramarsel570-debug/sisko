@extends('layouts.app') 

@section('title', 'Tambah Jurnal Guru')

@section('content')
<div class="container">
    <h3 class="mb-4">Tambah Jurnal Guru</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('guru.jurnal.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" 
                        value="{{ \Carbon\Carbon::now()->toDateString() }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="kelas" class="form-label">Kelas</label>
                    <input type="text" class="form-control" value="{{ $jadwal->kelas->nama_kelas }}" readonly>
                    <input type="hidden" name="kelas_id" value="{{ $jadwal->kelas_id }}">
                </div>

                <div class="mb-3">
                    <label for="mapel" class="form-label">Mata Pelajaran</label>
                    <input type="text" class="form-control" value="{{ $jadwal->mataPelajaran->nama_mapel }}" readonly>
                    <input type="hidden" name="mapel" value="{{ $jadwal->mataPelajaran->nama_mapel }}">
                </div>

                <div class="mb-3">
                    <label for="materi" class="form-label">Materi</label>
                    <input type="text" name="materi" id="materi" class="form-control" value="{{ old('materi') }}" required>
                </div>

                <div class="mb-3">
                    <label for="catatan" class="form-label">Catatan</label>
                    <textarea name="catatan" id="catatan" rows="3" class="form-control">{{ old('catatan') }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('guru.jurnal.index') }}" class="btn btn-secondary">
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
@if(session('no_schedule'))
<script>
    Swal.fire({
        icon: 'warning',
        title: 'Peringatan',
        text: '{{ session('no_schedule') }}',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
    })
</script>
@endif
@endsection