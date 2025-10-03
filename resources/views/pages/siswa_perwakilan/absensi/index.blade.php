@extends('layouts.app-siswa_perwakilan')


@section('title', 'Absensi Hari Ini')

@section('content')
<div class="row">
    <div class="col-md-12">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold"><i class="ti ti-clipboard-list"></i> Absensi Hari Ini</h3>
            <a href="{{ route('siswa_perwakilan.absensi.rekap') }}" class="btn btn-outline-primary">
                <i class="ti ti-table"></i> Lihat Rekap
            </a>
        </div>

        <!-- Info -->
        <div class="alert alert-info">
            <i class="ti ti-calendar"></i> Tanggal: <strong>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</strong>  
            <br>
            <i class="ti ti-building"></i> Kelas: <strong>{{ $kelas->nama_kelas }}</strong>
        </div>

        @if($isWeekend)
            <div class="alert alert-warning">
                <i class="ti ti-ban"></i> Hari ini libur (Sabtu/Minggu). Absensi tidak dapat diisi.
            </div>
        @elseif($sudahAdaAbsensi)
            <div class="alert alert-success">
                <i class="ti ti-check"></i> Absensi untuk hari ini sudah diisi.
            </div>

            <!-- tampilkan absensi yang sudah diisi -->
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($absensiHariIni as $i => $absen)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td class="text-start">{{ $absen->siswa->nama }}</td>
                                    <td>
                                        @if($absen->status == 'hadir') Hadir
                                        @elseif($absen->status == 'izin') Izin
                                        @elseif($absen->status == 'sakit') Sakit
                                        @elseif($absen->status == 'alfa') Alfa
                                        @endif
                                    </td>
                                    <td>{{ $absen->keterangan ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        @else
            <!-- form input absensi -->
            <form action="{{ route('siswa_perwakilan.absensi.store') }}" method="POST">
                @csrf
                <div class="card shadow-sm">
                    <div class="card-body table-responsive">
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($siswaKelas as $i => $s)
                                    <tr>
                                        <td>{{ $i+1 }}</td>
                                        <td class="text-start">{{ $s->nama }}</td>
                                        <td>
                                            <select name="absensi[{{ $s->id }}][status]" class="form-select" required>
                                                <option value="">-- pilih --</option>
                                                <option value="hadir">Hadir</option>
                                                <option value="izin">Izin</option>
                                                <option value="sakit">Sakit</option>
                                                <option value="alfa">Alfa</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" name="absensi[{{ $s->id }}][keterangan]" class="form-control" placeholder="Opsional">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-3 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy"></i> Simpan Absensi
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        @endif

    </div>
</div>
@endsection