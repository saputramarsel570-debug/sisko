@extends('layouts.app-guru')

@section('title', 'Riwayat Absensi Siswa')

@section('content')

<div class="card shadow-sm border-0 rounded-4">
    <!-- Header biru -->
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
        <div>
            <h4 class="mb-1 fw-bold">
                <i class="bi bi-clock-history"></i> Riwayat Absensi Siswa
            </h4>
            <small>
                <i class="bi bi-calendar-week"></i> 
                Periode: {{ $periode ?? \Carbon\Carbon::now()->translatedFormat('F Y') }}
                &nbsp; | &nbsp;
                <i class="bi bi-people"></i> 
                Kelas: {{ $kelasTerpilih->nama_kelas ?? ($selectedKelas ? 'Kelas tidak ditemukan' : '-') }}
            </small>
        </div>
        <div>
            <!-- Tombol kembali -->
            <a href="{{ route('guru.absensi.index') }}" class="btn btn-light btn-sm text-primary fw-semibold shadow-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card-body">

        <!-- Filter Pilih Kelas -->
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-4">
                <select name="kelas_id" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->ide }}" {{ $selectedKelas == $k->ide ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        <!-- Tabel Riwayat Absensi -->
        <table class="table table-bordered align-middle">
            <thead class="table-primary">
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
                        <td colspan="6" class="text-center text-muted py-4">
                            Belum ada data riwayat absensi
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
<script type="text/javascript">
$(function() {
    $('.dataTable').DataTable();
});
</script>
@endpush