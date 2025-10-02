@extends('layouts.app')

@section('title', 'Rekap Jurnal')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="fw-bold mb-4"><i class="ti ti-notebook"></i> Rekap Jurnal</h3>

        <!-- Filter -->
        <form method="GET" action="{{ route('admin.jurnal.rekap') }}" class="row g-3 mb-3">
            <div class="col-md-4">
                <select name="kelas_id" class="form-select" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" {{ $kelasId == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="ti ti-search"></i> Tampilkan
                </button>
            </div>
        </form>

        <!-- Tabel Rekap -->
        <div class="card shadow-lg border-0 rounded-4">
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
                        @forelse($jurnals as $jurnal)
                            @php
                                // Konversi ke jam teks
                                $jamMulai = $jurnal->jam_mulai;
                                $jamSelesai = $jurnal->jam_selesai;

                                // misal jam_mulai = 1 → ambil mapping jam ke
                                $jamRanges = [
                                    1 => '07:00 - 07:45',
                                    2 => '07:45 - 08:30',
                                    3 => '08:30 - 09:15',
                                    4 => '09:30 - 10:15',
                                    5 => '10:15 - 11:00',
                                    6 => '11:00 - 11:45',
                                    7 => '12:30 - 13:15',
                                    8 => '13:15 - 14:00',
                                    9 => '14:00 - 14:45',
                                    10 => '14:45 - 15:30',
                                ];

                                $mulaiParts = explode(' - ', $jamRanges[$jamMulai] ?? $jamMulai);
                                $selesaiParts = explode(' - ', $jamRanges[$jamSelesai] ?? $jamSelesai);
                                $jamTampil = ($mulaiParts[0] ?? $jamMulai) . ' - ' . ($selesaiParts[1] ?? $jamSelesai);
                            @endphp
                            <tr>
                                <td>{{ $jamTampil }}</td>
                                <td>{{ $jurnal->mataPelajaran->nama_mapel ?? '-' }}</td>
                                <td>{{ $jurnal->guru->nama ?? '-' }}</td>
                                <td>{{ $jurnal->materi }}</td>
                                <td>{{ $jurnal->catatan }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Tidak ada jurnal pada tanggal ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
