@extends('layouts.app')

@section('title', 'Jadwal Pelajaran')

@section('content')
<div class="row">
    <div class="col-md-12">
        @if (session('success'))
            <div id="success" class="alert alert-solid-success d-flex align-items-center" role="alert">
                <span class="alert-icon rounded"><i class="ti ti-check"></i></span>
                {{ session('success') }}
            </div>
        @endif
        <h3 class="page-title">Jadwal Pelajaran</h3>

        <form method="GET" class="mb-3">
            <div class="row g-2">
                <div class="col-md-4">
                    <select name="kelas_id" class="form-select" onchange="this.form.submit()">
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

        @if($kelasId)
            <div class="d-flex justify-content-between mb-2">
                <h5>Jadwal Kelas: {{ $kelasList->find($kelasId)->nama_kelas }}</h5>
                <div class="d-flex gap-2">
                    <form action="{{ route('jadwal.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" id="file" class="form-control form-control-sm d-inline-block" required>
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="ti ti-file-import"></i> Import Jadwal
                        </button>
                    </form>
                </div>
                <a href="{{ route('admin.jadwal.edit', $kelasId) }}" class="btn btn-warning btn-sm">
                    <i class="ti ti-edit"></i> Edit Jadwal
                </a>
            </div>

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-bordered text-center align-middle">
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
                        <thead class="table-light">
                            <tr>
                                <th>Hari</th>
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
                                    <td><strong>{{ $hari }}</strong></td>

                                    @php
                                        $jam = 1;
                                    @endphp

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
        @else
            <div class="alert alert-info">Silakan pilih kelas terlebih dahulu untuk melihat jadwal.</div>
        @endif
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
