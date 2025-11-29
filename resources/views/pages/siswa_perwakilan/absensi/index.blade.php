@extends('layouts.app-siswa_perwakilan')

@section('title', 'Absensi Hari Ini')

@section('content')
<div class="row">
    <div class="col-md-12">

        <div class="card shadow-sm border-0 mb-4">

            {{-- HEADER --}}
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

            {{-- BODY --}}
            <div class="card-body">

                {{-- WEEKEND --}}
                @if($isWeekend)
                    <div class="alert alert-warning">
                        <i class="ti ti-ban"></i> Hari ini libur (Sabtu/Minggu). Absensi tidak dapat diisi.
                    </div>

                {{-- SUDAH ABSEN --}}
                @elseif($sudahAdaAbsensi)
                    <div class="alert alert-success">
                        <i class="ti ti-check"></i> Absensi untuk hari ini sudah diisi.
                    </div>

                    <div class="table-responsive mt-3">
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
                                    <td>{{ ucfirst($absen->status) }}</td>
                                    <td>{{ $absen->keterangan ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                @else

                {{-- FORM ABSENSI --}}
                <form method="POST"> action="{{ route('siswa_perwakilan.absensi.store') }}" 
                    @csrf

                    <div class="table-responsive mt-3">
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

                                    {{-- STATUS --}}
                                    <td>

                                        <select 
                                            name="absensi[{{ $s->id }}][status]"
                                            class="form-select @error('absensi.'.$s->id.'.status') is-invalid @enderror"
                                            required
                                        >
                                            <option value="">-- pilih --</option>
                                            <option value="hadir" {{ old("absensi.$s->id.status") == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                            <option value="izin"  {{ old("absensi.$s->id.status") == 'izin'  ? 'selected' : '' }}>Izin</option>
                                            <option value="sakit" {{ old("absensi.$s->id.status") == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                            <option value="alfa"  {{ old("absensi.$s->id.status") == 'alfa'  ? 'selected' : '' }}>Alfa</option>
                                        </select>

                                        {{-- ERROR STATUS --}}
                                        @error('absensi.'.$s->id.'.status')
                                            <div class="invalid-feedback d-block mt-1">
                                                <i class="ti ti-alert-triangle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </td>

                                    {{-- KETERANGAN --}}
                                    <td>
                                        <input
                                            type="text"
                                            name="absensi[{{ $s->id }}][keterangan]"
                                            class="form-control @error('absensi.'.$s->id.'.keterangan') is-invalid @enderror"
                                            value="{{ old("absensi.$s->id.keterangan") }}"
                                            placeholder="Opsional"
                                        >

                                        @error('absensi.'.$s->id.'.keterangan')
                                            <div class="invalid-feedback d-block mt-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
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