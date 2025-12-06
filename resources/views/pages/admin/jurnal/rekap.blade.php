@extends('layouts.app')

@section('title', 'Rekap Jurnal')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="ti ti-notebook"></i> Rekap Jurnal</h4>
        </div>

        <div class="card-body">
            {{-- Filter --}}
            <form method="GET" action="{{ route('admin.jurnal.rekap') }}" class="row g-3 mb-4 align-items-end">
                <div class="col-md-3">
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
                @if($mode == 'bulanan' && $kelasId)
                <div class="col-md-2">
                    <a href="{{ route('admin.jurnal.rekap.export', ['kelas_id' => $kelasId, 'periode' => $periode]) }}" 
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
                                    <td class="text-start">{{ $jurnal->materi ?? '-' }}</td>
                                    <td class="text-start fst-italic">{{ $jurnal->catatan ?? '-' }}</td>
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

                {{-- ================== MODE BULANAN (UPDATE: termasuk kolom JAM) ================== --}}
                @elseif($mode == 'bulanan')
    @if($jadwalBulanan->isEmpty())
        <div class="text-center text-muted py-4">
            <i class="ti ti-alert-circle fs-4"></i><br>
            Tidak ada jadwal untuk bulan ini
        </div>
    @else
        @foreach($jadwalBulanan as $tanggal => $jadwalHarian)
            <div class="mb-4">
                <h5 class="fw-bold text-primary mb-2">
                    <i class="ti ti-calendar"></i>
                    {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
                </h5>

                @php
                    // --- GROUPING JAM BERURUTAN (MERGE) ---
                    $groups = [];
                    $temp = null;

                    foreach ($jadwalHarian as $item) {
                        $slotStart = $item->jam_mulai;
                        $slotEnd   = $item->jam_selesai;

                        if (!$temp) {
                            $temp = [
                                'start' => $slotStart,
                                'end'   => $slotEnd,
                                'mapel' => $item->mata_pelajaran_id,
                                'guru'  => $item->guru_id,
                                'items' => [$item],
                            ];
                            continue;
                        }

                        $isConsecutive = ($slotStart == $temp['end'] + 1);
                        $isSameMapel   = ($item->mata_pelajaran_id == $temp['mapel']);
                        $isSameGuru    = ($item->guru_id == $temp['guru']);

                        if ($isConsecutive && $isSameMapel && $isSameGuru) {
                            $temp['end'] = $slotEnd;
                            $temp['items'][] = $item;
                        } else {
                            $groups[] = $temp;
                            $temp = [
                                'start' => $slotStart,
                                'end'   => $slotEnd,
                                'mapel' => $item->mata_pelajaran_id,
                                'guru'  => $item->guru_id,
                                'items' => [$item],
                            ];
                        }
                    }
                    if ($temp) $groups[] = $temp;

                    // Function ambil rentang jam
                    $getRange = function($slot) use ($jamRanges) {
                        return $jamRanges[$slot] ?? null;
                    };
                @endphp

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle shadow-sm">
                        <thead class="table-light">
                            <tr>
                                <th width="8%">Jam</th>
                                <th width="22%">Mata Pelajaran</th>
                                <th width="18%">Guru</th>
                                <th width="26%">Materi</th>
                                <th width="26%">Catatan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($groups as $group)
                                @php
                                    $items = $group['items'];
                                    $rowspan = count($items);
                        
                                    $startRange = $getRange($group['start']);
                                    $endRange   = $getRange($group['end']);
                        
                                    $startPart = explode(' - ', $startRange)[0] ?? '';
                                    $endPart   = explode(' - ', $endRange)[1] ?? '';
                        
                                    $finalJam = "$startPart - $endPart";
                        
                                    $jurnalForDate = $jurnalBulanan[$tanggal] ?? collect();
                                    $jurnal = $jurnalForDate->firstWhere('mata_pelajaran_id', $group['mapel']);
                        
                                    $first = $items[0];
                                @endphp
                                <tr>
                                    <td class="text-center align-middle" rowspan="{{ $rowspan }}">
                                        <span class="badge bg-primary">{{ $finalJam }}</span>
                                    </td>
                        
                                    <td class="align-middle" rowspan="{{ $rowspan }}">
                                        {{ $first->mataPelajaran->nama_mapel ?? '-' }}
                                    </td>
                        
                                    <td class="align-middle" rowspan="{{ $rowspan }}">
                                        {{ $first->guru->nama ?? '-' }}
                                    </td>
                        
                                    <td class="align-middle" rowspan="{{ $rowspan }}">
                                        {{ $jurnal->materi ?? '-' }}
                                    </td>
                        
                                    <td class="align-middle fst-italic" rowspan="{{ $rowspan }}">
                                        {{ $jurnal->catatan ?? '-' }}
                                    </td>
                                </tr>
                                @for($i = 1; $i < $rowspan; $i++)
                                    <tr>
                                        <td style="display:none"></td>
                                        <td style="display:none"></td>
                                        <td style="display:none"></td>
                                        <td style="display:none"></td>
                                        <td style="display:none"></td>
                                    </tr>
                                @endfor
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