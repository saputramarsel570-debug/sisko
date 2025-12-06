@extends('layouts.app-guru')

@section('title', 'Jurnal Mengajar')

@section('content')
<div class="row">
    <div class="col-md-12">

        @if (session('success'))
            <div id="success" class="alert alert-solid-success d-flex align-items-center" role="alert">
                <span class="alert-icon rounded"><i class="ti ti-check"></i></span>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-solid-danger d-flex align-items-center" role="alert">
                <span class="alert-icon rounded"><i class="ti ti-alert-triangle"></i></span>
                {{ session('error') }}
            </div>
        @endif

        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <h3 class="fw-bold mb-3 mb-md-0">
                <i class="ti ti-notebook"></i> Jurnal Mengajar
            </h3>

            <form method="GET" action="{{ route('guru.jurnal.index') }}"
                class="d-flex flex-wrap gap-2 align-items-center">

                <div class="flex-grow-1" style="min-width: 180px;">
                    <select name="kelas_id" class="form-select shadow-sm" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach(\App\Models\Kelas::all() as $k)
                            <option value="{{ $k->id }}" {{ $kelasId == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="min-width: 180px;">
                    <input type="date"
                        name="tanggal"
                        class="form-control shadow-sm"
                        max="{{ now()->toDateString() }}"
                        value="{{ $tanggal ?? now()->toDateString() }}">
                </div>

                <div>
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="ti ti-search"></i> Tampilkan
                    </button>
                </div>

            </form>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    Jurnal Tanggal: {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d M Y') }}
                </h5>
            </div>

            <form action="{{ route('guru.jurnal.store') }}" method="POST">
                @csrf
                <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
                <input type="hidden" name="tanggal" value="{{ $tanggal }}">

                <div class="card-body p-0">
                    <table class="table table-bordered mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="15%">Jam</th>
                                <th width="20%">Mata Pelajaran</th>
                                <th width="20%">Guru</th>
                                <th width="22%">Materi</th>
                                <th width="23%">Catatan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($jadwalGabung as $jadwal)
                                @php
                                    $key = $jadwal->jam_mulai . '-' 
                                        . $jadwal->jam_selesai . '-' 
                                        . $jadwal->mata_pelajaran_id . '-' 
                                        . $jadwal->guru_id;

                                    $jurnal = $jurnalMerged[$key] ?? null;

                                    $isGuruSendiri = $jadwal->guru_id == $guru->id;

                                    $mulaiParts = explode(' - ', $jamRanges[$jadwal->jam_mulai] ?? $jadwal->jam_mulai);
                                    $selesaiParts = explode(' - ', $jamRanges[$jadwal->jam_selesai] ?? $jadwal->jam_selesai);
                                    $jamTampil = ($mulaiParts[0] ?? $jadwal->jam_mulai) 
                                        . ' - ' 
                                        . ($selesaiParts[1] ?? $jadwal->jam_selesai);
                                @endphp

                                <tr>
                                    <td><span class="badge bg-primary">{{ $jamTampil }}</span></td>
                                    <td>{{ $jadwal->mataPelajaran->nama_mapel ?? '-' }}</td>
                                    <td>{{ $jadwal->guru->nama }}</td>

                                    <td>
                                        @if($isGuruSendiri)
                                            <input type="text"
                                                name="jurnal[{{ $key }}][materi]"
                                                class="form-control"
                                                value="{{ old("jurnal.$key.materi", $jurnal->materi ?? '') }}">
                                        @else
                                            <input type="text" class="form-control"
                                                value="{{ $jurnal->materi ?? '-' }}" disabled>
                                        @endif
                                    </td>

                                    <td>
                                        @if($isGuruSendiri)
                                            <input type="text"
                                                name="jurnal[{{ $key }}][catatan]"
                                                class="form-control"
                                                value="{{ old("jurnal.$key.catatan", $jurnal->catatan ?? '') }}">
                                        @else
                                            <input type="text" class="form-control"
                                                value="{{ $jurnal->catatan ?? '-' }}" disabled>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="ti ti-alert-circle"></i><br>
                                        Tidak ada jadwal pelajaran pada tanggal ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($jadwalGabung->count())
                    <div class="card-footer d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">
                            <i class="ti ti-device-floppy"></i> Simpan Semua
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection