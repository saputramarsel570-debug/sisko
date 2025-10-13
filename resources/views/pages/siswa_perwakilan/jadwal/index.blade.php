@extends('layouts.app-siswa_perwakilan')

@section('title', 'Jadwal Pelajaran')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center bg-primary text-white rounded-top-4">
                <div class="d-flex align-items-center gap-3">
                    <h4 class="mb-0 fw-bold"><i class="ti ti-calendar me-2"></i> Jadwal Pelajaran</h4>
                    <form method="GET" id="kelasForm">
                        <select name="kelas_id" class="form-select form-select-sm bg-black text-white" onchange="this.form.submit()">
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}" {{ $kelasId == $kelas->id ? 'selected' : '' }}>
                                    {{ $kelas->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
                @if($kelasId)
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('jadwal.exportPdf', $kelasId) }}" target="_blank" class="btn btn-danger btn-sm">
                        <i class="ti ti-file-type-pdf"></i> Export PDF
                    </a>
                </div>
            @endif
            </div>

            @if($kelasId)
                <h5 class="fw-bold mb-3 mt-3">Jadwal Kelas: {{ $kelasList->find($kelasId)->nama_kelas }}</h5>

                @php
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
                @endphp

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle text-center">
                        <thead class="text-center align-middle table-light">
                            <tr>
                                <th class="text-center align-middle" style="width: 120px;">Hari</th>
                                @for($jam = 1; $jam <= 10; $jam++)
                                    <th>
                                        Jam {{ $jam }} <br>
                                        <small class="text-muted">{{ $jamRanges[$jam] }}</small>
                                    </th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat'] as $hari)
                                <tr>
                                    <td class="fw-bold">{{ $hari }}</td>
                                    @php $jam = 1; @endphp
                                    @while($jam <= 10)
                                        @if(isset($jadwalByHari[$hari][$jam]))
                                            @php
                                                $current = $jadwalByHari[$hari][$jam];
                                                $colspan = 1;
                                                for ($next = $jam + 1; $next <= 10; $next++) {
                                                    if (
                                                        isset($jadwalByHari[$hari][$next]) &&
                                                        $jadwalByHari[$hari][$next]->mata_pelajaran_id == $current->mata_pelajaran_id &&
                                                        $jadwalByHari[$hari][$next]->guru_id == $current->guru_id
                                                    ) {
                                                        $colspan++;
                                                    } else {
                                                        break;
                                                    }
                                                }
                                            @endphp
                                            <td colspan="{{ $colspan }}">
                                                <strong>{{ $current->mataPelajaran->nama_mapel }}</strong><br>
                                                <small>{{ $current->guru->nama ?? '-' }}</small>
                                            </td>
                                            @php $jam += $colspan; @endphp
                                        @else
                                            <td class="text-muted">-</td>
                                            @php $jam++; @endphp
                                        @endif
                                    @endwhile
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info mt-3">
                    <i class="ti ti-info-circle me-2"></i> Silakan pilih kelas terlebih dahulu untuk melihat jadwal.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    setTimeout(function () {
        let alert = document.getElementById('success');
        if (alert) {
            alert.style.transition = "opacity 0.5s ease";
            alert.style.opacity = 0;
            setTimeout(() => alert.remove(), 500);
        }
    }, 3000);
</script>
@endpush