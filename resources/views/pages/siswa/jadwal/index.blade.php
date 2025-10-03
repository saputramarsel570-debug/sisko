@extends('layouts.app-siswa')

@section('title', 'Jadwal Pelajaran')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="page-title mb-3">Jadwal Pelajaran</h3>
        <div class="card mb-4">
            <a href="{{ route('admin.jadwal.export') }}" class="btn btn-success btn-sm me-2">
                <i class="ti ti-download"></i> Export
            </a>
            <div class="card-body">
                <form method="GET" class="mb-0">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <select name="kelas_id" class="form-select bg-white" onchange="this.form.submit()">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}" {{ $kelasId == $kelas->id ? 'selected' : '' }}>
                                        {{ $kelas->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if($kelasId)
            <div class="card">
                <div class="card-body table-responsive">
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

                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 100px;">Hari</th>
                                @foreach($jamRanges as $jam => $range)
                                    <th style="min-width: 120px;">
                                        Jam {{ $jam }} <br>
                                        <small class="text-muted">{{ $range }}</small>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat'] as $hari)
                                <tr>
                                    <td><strong>{{ $hari }}</strong></td>

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

                                            <td colspan="{{ $colspan }}" class="bg-light">
                                                <strong>{{ $current->mataPelajaran->nama_mapel }}</strong><br>
                                                <small class="text-muted">{{ $current->guru->nama ?? '-' }}</small>
                                            </td>

                                            @php $jam += $colspan; @endphp
                                        @else
                                            <td>-</td>
                                            @php $jam++; @endphp
                                        @endif
                                    @endwhile
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection