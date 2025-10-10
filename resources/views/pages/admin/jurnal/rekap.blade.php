@extends('layouts.app')

@section('title', 'Rekap Jurnal')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="ti ti-notebook"></i> Rekap Jurnal</h4>
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('admin.jurnal.rekap') }}" class="row g-3 mb-4 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Kelas</label>
                    <select name="kelas_id" class="form-select shadow-sm" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id }}" {{ $kelasId == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control shadow-sm" value="{{ $tanggal }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 shadow-sm">
                        <i class="ti ti-search"></i> Tampilkan
                    </button>
                </div>
            </form>

            <!-- Tabel Rekap -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle text-center shadow-sm rounded-3 overflow-hidden">
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
                                $jurnal = $jurnalHariIni[$jadwal->jam_mulai.'-'.$jadwal->jam_selesai] ?? null;

                                $mulaiParts = explode(' - ', $jamRanges[$jadwal->jam_mulai] ?? $jadwal->jam_mulai);
                                $selesaiParts = explode(' - ', $jamRanges[$jadwal->jam_selesai] ?? $jadwal->jam_selesai);
                                $jamTampil = ($mulaiParts[0] ?? $jadwal->jam_mulai) . ' - ' . ($selesaiParts[1] ?? $jadwal->jam_selesai);
                            @endphp
                            <tr>
                                <td><span class="badge bg-primary">{{ $jamTampil }}</span></td>
                                <td class="text-start">{{ $jadwal->mataPelajaran->nama_mapel ?? '-' }}</td>
                                <td>{{ $jadwal->guru->nama ?? '-' }}</td>
                                <td class="text-start">
                                    @if($jurnal && $jurnal->materi)
                                        <span class="text-dark">{{ $jurnal->materi }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-start">
                                    @if($jurnal && $jurnal->catatan)
                                        <span class="fst-italic">{{ $jurnal->catatan }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="ti ti-alert-circle fs-4"></i><br>
                                    Tidak ada jadwal untuk hari ini
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
