@extends('layouts.app')

@section('title', 'Riwayat Absensi Siswa')

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Riwayat Absensi Siswa</h4>
        <div>
            <!-- Tombol kembali ke absensi hari ini -->
            <a href="{{ route('guru.absensi.index') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
    <div class="card-body">

        <!-- Filter Pilih Kelas -->
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-4">
                <select name="kelas_id" class="form-control" onchange="this.form.submit()">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ $selectedKelas == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        <!-- Tabel Riwayat Absensi -->
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Tanggal</th>
                    <th>Hari</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensi as $a)
                    <tr>
                        <td>{{ $a->siswa->nama }}</td>
                        <td>{{ $a->kelas->nama_kelas }}</td>
                        <td>{{ \Carbon\Carbon::parse($a->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($a->tanggal)->translatedFormat('l') }}</td>
                        <td>
                            @if($a->status == 'hadir')
                                <span class="badge bg-success">Hadir</span>
                            @elseif($a->status == 'izin')
                                <span class="badge bg-warning text-dark">Izin</span>
                            @elseif($a->status == 'sakit')
                                <span class="badge bg-info text-dark">Sakit</span>
                            @else
                                <span class="badge bg-danger">Alfa</span>
                            @endif
                        </td>
                        <td>{{ $a->keterangan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            Belum ada data riwayat absensi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>
@endsection