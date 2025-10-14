@extends('layouts.app-siswa')

@section('title', 'Absensi Siswa')

@section('content')
<div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
        <h4 class="mb-0 fw-bold"><i class="bi bi-calendar-check"></i> Absensi Siswa</h4>
    </div>

    <div class="card-body">
        <!-- Filter -->
        <form method="GET" class="row g-2 mb-3 align-items-center">
            <!-- Pilih kelas -->
            <div class="col-md-3">
                <select name="kelas_id" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ $selectedKelas == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
        
            <!-- Pilih periode -->
            <div class="col-md-2">
                <select name="periode" id="periode" class="form-select" onchange="this.form.submit()">
                    <option value="harian" {{ $periode == 'harian' ? 'selected' : '' }}>Harian</option>
                    <option value="bulanan" {{ $periode == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                </select>
            </div>
        
            <!-- Pilih tanggal (kalau harian) -->
            @if($periode == 'harian')
                <div class="col-md-3">
                    <input type="date" name="tanggal" class="form-control"
                        value="{{ $tanggal }}"
                        onchange="this.form.submit()">
                </div>
            @endif
        
            <!-- Pilih bulan dan tahun (kalau bulanan) -->
            @if($periode == 'bulanan')
                <div class="col-md-2">
                    <select name="bulan" class="form-select" onchange="this.form.submit()">
                        @foreach(range(1,12) as $m)
                            <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
        
                <div class="col-md-2">
                    <select name="tahun" class="form-select" onchange="this.form.submit()">
                        @foreach(range(date('Y')-2, date('Y')+1) as $y)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
        </form>

        <!-- Tabel -->
        <table class="table table-bordered align-middle">
            <thead class="table-primary">
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
                        <td>
                            <textarea class="form-control form-control-sm" rows="1" readonly>{{ $a->keterangan }}</textarea>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            Tidak ada data absensi untuk periode ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ asset('/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endpush

@push('scripts')
<script src="{{ asset('/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
<script src="{{ asset('/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script>
$(function(){
    $('.dataTable').DataTable();
});
</script>
@endpush