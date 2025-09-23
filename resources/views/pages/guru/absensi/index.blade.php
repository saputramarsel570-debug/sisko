@extends('layouts.app')

@section('title', 'Absensi Siswa')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">Absensi Siswa</h4>
    </div>
    <div class="card-body">

        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-3">
                <select name="bulan" class="form-control">
                    @foreach(range(1, 12) as $b)
                        <option value="{{ $b }}" {{ $b == $bulan ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="tahun" class="form-control">
                    @for($y = now()->year; $y >= now()->year - 3; $y--)
                        <option value="{{ $y }}" {{ $y == $tahun ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary" type="submit">Filter</button>
            </div>
        </form>

        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Nama Siswa</th>
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
                        <td colspan="5" class="text-center">Belum ada data absensi bulan ini</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>
@endsection