@extends('layouts.app-guru')

@section('title', 'Rekap Jurnal Saya')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="ti ti-notebook"></i> Rekap Jurnal Saya</h4>
        </div>

        <div class="card-body">
            {{-- FILTER --}}
            <form method="GET" action="{{ route('guru.jurnals.rekap') }}" class="row g-3 mb-4 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Mode Rekap</label>
                    <select name="mode" class="form-select shadow-sm" id="modeSelect">
                        <option value="harian" {{ $mode == 'harian' ? 'selected' : '' }}>Harian</option>
                        <option value="bulanan" {{ $mode == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                    </select>
                </div>

                {{-- Input tanggal untuk harian --}}
                <div class="col-md-3 mode-harian {{ $mode == 'bulanan' ? 'd-none' : '' }}">
                    <label class="form-label fw-semibold">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control shadow-sm" value="{{ $tanggal }}">
                </div>

                {{-- Input periode untuk bulanan --}}
                <div class="col-md-3 mode-bulanan {{ $mode == 'harian' ? 'd-none' : '' }}">
                    <label class="form-label fw-semibold">Bulan</label>
                    <input type="month" name="periode" class="form-control shadow-sm" value="{{ $periode }}">
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 shadow-sm">
                        <i class="ti ti-search"></i> Tampilkan
                    </button>
                </div>

                {{-- Tombol Export PDF hanya muncul di mode bulanan --}}
                @if($mode == 'bulanan' && !$jurnalBulanan->isEmpty())
                    <div class="col-md-2">
                        <a href="{{ route('guru.jurnals.rekap.export', ['periode' => $periode]) }}" 
                           class="btn btn-danger w-100 shadow-sm" target="_blank">
                            <i class="ti ti-file-type-pdf"></i> Export PDF
                        </a>
                    </div>
                @endif
            </form>

            {{-- ================== MODE HARIAN ================== --}}
            @if($mode == 'harian')
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle text-center shadow-sm rounded-3 overflow-hidden">
                        <thead class="table-light">
                            <tr>
                                <th width="15%">Jam</th>
                                <th width="20%">Kelas</th>
                                <th width="20%">Mata Pelajaran</th>
                                <th width="25%">Materi</th>
                                <th width="20%">Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jurnalHariIni as $jurnal)
                                <tr>
                                    <td>
                                        @php
                                            $start = $jurnal->jam_mulai ?? null;
                                            $end = $jurnal->jam_selesai ?? null;
                                    
                                            // fungsi bantu untuk ambil range dari jamRanges
                                            $getRangePart = function($key, $partIndex) use ($jamRanges) {
                                                if ($key === null) return null;
                                    
                                                if (isset($jamRanges[(int)$key])) {
                                                    $range = $jamRanges[(int)$key]; // contoh: "14:00 - 14:45"
                                                    $parts = explode(' - ', $range);
                                                    return $parts[$partIndex] ?? null;
                                                }
                                                return null;
                                            };
                                    
                                            // ambil waktu mulai/akhir
                                            $startTime = $getRangePart($start, 0); // "14:00"
                                            $endTime = $getRangePart($end, 1);     // "15:30"
                                    
                                            // fallback jika jamRanges tidak tersedia
                                            if (!$startTime && $start) {
                                                try {
                                                    $startTime = \Carbon\Carbon::parse($start)->format('H:i');
                                                } catch (\Throwable $e) {}
                                            }
                                            if (!$endTime && $end) {
                                                try {
                                                    $endTime = \Carbon\Carbon::parse($end)->format('H:i');
                                                } catch (\Throwable $e) {}
                                            }
                                    
                                            // hasil akhir
                                            if ($startTime && $endTime && $startTime !== $endTime) {
                                                $jamOutput = $startTime . ' - ' . $endTime;
                                            } elseif ($startTime) {
                                                $jamOutput = $startTime;
                                            } else {
                                                $jamOutput = '-';
                                            }
                                        @endphp
                                    
                                        <span class="badge bg-primary">{{ $jamOutput }}</span>
                                    </td>
                                    <td>{{ $jurnal->kelas->nama_kelas ?? '-' }}</td>
                                    <td>{{ $jurnal->mataPelajaran->nama_mapel ?? '-' }}</td>
                                    <td class="text-start">{{ $jurnal->materi ?? '-' }}</td>
                                    <td class="text-start fst-italic">{{ $jurnal->catatan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="ti ti-alert-circle fs-4"></i><br>
                                        Tidak ada jurnal untuk tanggal ini
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            {{-- ================== MODE BULANAN ================== --}}
            @elseif($mode == 'bulanan')
                @if($jurnalBulanan->isEmpty())
                    <div class="text-center text-muted py-4">
                        <i class="ti ti-alert-circle fs-4"></i><br>
                        Tidak ada jurnal untuk bulan ini
                    </div>
                @else
                    @foreach($jurnalBulanan as $tanggal => $data)
                        <div class="mb-4">
                            <h5 class="fw-bold text-primary mb-2">
                                <i class="ti ti-calendar"></i> {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
                            </h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle shadow-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="15%">Kelas</th>
                                            <th width="20%">Mata Pelajaran</th>
                                            <th width="15%">Jam</th>
                                            <th width="25%">Materi</th>
                                            <th width="20%">Catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $i => $jurnal)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $jurnal->kelas->nama_kelas ?? '-' }}</td>
                                                <td>{{ $jurnal->mataPelajaran->nama_mapel ?? '-' }}</td>
                                                <td>
                                                    @php
                                                        $start = $jurnal->jam_mulai ?? null;
                                                        $end = $jurnal->jam_selesai ?? null;
                                                
                                                        // fungsi bantu untuk ambil bagian waktu dari jamRanges jika tersedia
                                                        $getRangePart = function($key, $partIndex) use ($jamRanges) {
                                                            if ($key === null) return null;
                                                            // kalau jamRanges memiliki entry untuk key
                                                            if (isset($jamRanges[(int)$key])) {
                                                                $range = $jamRanges[(int)$key]; // contohnya "07:00 - 07:45"
                                                                $parts = explode(' - ', $range);
                                                                return $parts[$partIndex] ?? null;
                                                            }
                                                            return null;
                                                        };
                                                
                                                        // coba ambil waktu mulai/akhir dari jamRanges
                                                        $startTime = $getRangePart($start, 0); // "07:00" atau null
                                                        $endTime = $getRangePart($end, 1);     // "07:45" atau null
                                                
                                                        // jika jamRanges tidak tersedia, coba format langsung dari value (mis. "08:45:00")
                                                        if (!$startTime && $start) {
                                                            try {
                                                                $startTime = \Carbon\Carbon::parse($start)->format('H:i');
                                                            } catch (\Throwable $e) {
                                                                $startTime = null;
                                                            }
                                                        }
                                                        if (!$endTime && $end) {
                                                            try {
                                                                $endTime = \Carbon\Carbon::parse($end)->format('H:i');
                                                            } catch (\Throwable $e) {
                                                                $endTime = null;
                                                            }
                                                        }
                                                
                                                        // siapkan string output
                                                        if ($startTime && $endTime && $startTime !== $endTime) {
                                                            $jamOutput = $startTime . ' - ' . $endTime;
                                                        } elseif ($startTime) {
                                                            // hanya punya startTime (tampilkan start)
                                                            $jamOutput = $startTime;
                                                        } elseif ($start !== null && $end !== null && $start != $end) {
                                                            // fallback: tampilkan angka jam ke, mis. "9 - 10"
                                                            $jamOutput = $start . ' - ' . $end;
                                                        } else {
                                                            // fallback simple
                                                            $jamOutput = $start ?? ($end ?? '-');
                                                        }
                                                    @endphp
                                                
                                                    @if($jamOutput && $jamOutput !== '-')
                                                        <span class="badge bg-primary">{{ $jamOutput }}</span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="text-start">{{ $jurnal->materi ?? '-' }}</td>
                                                <td class="text-start fst-italic">{{ $jurnal->catatan ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                @endif
            @endif
        </div>
    </div>
</div>

{{-- JS untuk ganti mode input --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modeSelect = document.getElementById('modeSelect');
    const harianField = document.querySelector('.mode-harian');
    const bulananField = document.querySelector('.mode-bulanan');

    modeSelect.addEventListener('change', function() {
        if (this.value === 'harian') {
            harianField.classList.remove('d-none');
            bulananField.classList.add('d-none');
        } else {
            harianField.classList.add('d-none');
            bulananField.classList.remove('d-none');
        }
    });
});
</script>
@endpush
@endsection