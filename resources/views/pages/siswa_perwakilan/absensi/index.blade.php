@extends('layouts.app-siswa_perwakilan')

@section('title', 'Absensi Hari Ini')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-primary text-white py-3">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                    <div>
                        <h5 class="mb-1 d-flex align-items-center gap-2">
                            <i class="ti ti-clipboard-list fs-4"></i>
                            Absensi Hari Ini
                        </h5>
                        <div class="small">
                            <i class="ti ti-calendar"></i> 
                            Tanggal: <strong>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</strong>
                            <span class="mx-2">|</span>
                            <i class="ti ti-building"></i> 
                            Kelas: <strong>{{ $kelas->nama_kelas }}</strong>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('siswa_perwakilan.absensi.rekap') }}" class="btn btn-light btn-sm">
                            <i class="ti ti-table"></i> Lihat Rekap
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                @if($isWeekend)
                    <div class="alert alert-warning">
                        <i class="ti ti-ban"></i> Hari ini libur (Sabtu/Minggu). Absensi tidak dapat diisi.
                    </div>
                @elseif($sudahAdaAbsensi)
                    <div class="alert alert-success">
                        <i class="ti ti-check"></i> Absensi untuk hari ini sudah diisi.
                    </div>

                    {{-- Tambah jarak di sini --}}
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 60px;">No</th>
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
                @else
                    <form action="{{ route('siswa_perwakilan.absensi.store') }}" method="POST">
                        @csrf
                        {{-- Tambah jarak di sini juga --}}
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 60px;">No</th>
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
                        </div>

                        <div class="mt-3 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy"></i> Simpan Absensi
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection