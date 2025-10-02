@extends('layouts.app')

@section('title', 'Rekap Jurnal Mengajar')

@section('content')
<div class="row">
    <div class="col-md-12">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold"><i class="ti ti-table"></i> Rekap Jurnal Mengajar</h3>
        </div>

        <form method="GET" action="{{ route('admin.rekap.jurnal.index') }}" class="row g-2 mb-3">
            <div class="col-md-3">
                <input type="date" name="tanggal" value="{{ $tanggal }}" class="form-control">
            </div>
            <div class="col-md-3">
                <select name="kelas_id" class="form-select">
                    <option value="">-- Semua Kelas --</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" {{ $kelasId == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="ti ti-search"></i> Filter
                </button>
            </div>
        </form>

        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-0">
                <table class="table table-bordered mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="10%">Tanggal</th>
                            <th width="15%">Kelas</th>
                            <th width="20%">Guru</th>
                            <th width="15%">Mapel</th>
                            <th width="10%">Jam</th>
                            <th width="15%">Materi</th>
                            <th width="15%">Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jurnal as $j)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($j->tanggal)->translatedFormat('d M Y') }}</td>
                                <td>{{ $j->kelas->nama_kelas }}</td>
                                <td>{{ $j->guru->nama }}</td>
                                <td>{{ $j->mataPelajaran->nama_mapel }}</td>
                                <td>{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</td>
                                <td>{{ $j->materi ?? '-' }}</td>
                                <td>{{ $j->catatan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Tidak ada jurnal pada tanggal ini
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
