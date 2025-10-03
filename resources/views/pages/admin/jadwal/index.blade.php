@extends('layouts.app')

@section('title', 'Jadwal Pelajaran')

@section('content')
<div class="row">
    <div class="col-md-12">

        {{-- Notifikasi sukses --}}
        @if (session('success'))
            <div id="success" class="alert alert-solid-success d-flex align-items-center" role="alert">
                <span class="alert-icon rounded"><i class="ti ti-check"></i></span>
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-lg border-0 rounded-4">
            {{-- HEADER CARD --}}
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center bg-primary text-white rounded-top-4">
                <div class="d-flex align-items-center gap-3">
                    <h4 class="mb-0 fw-bold"><i class="ti ti-calendar me-2"></i> Jadwal Pelajaran</h4>

                    {{-- Dropdown Pilih Kelas --}}
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

                {{-- Tombol Aksi --}}
                <div class="mt-2 mt-md-0">
                    @if($kelasId)
                        <a href="{{ route('admin.jadwal.edit', $kelasId) }}" class="btn btn-light btn-sm me-2">
                            <i class="ti ti-pencil"></i> Edit Jadwal
                        </a>
                        <a href="{{ route('admin.jadwal.export') }}" class="btn btn-success btn-sm me-2">
                            <i class="ti ti-download"></i> Export
                        </a>
                        <button class="btn btn-info btn-sm" data-bs-toggle="collapse" data-bs-target="#importForm">
                            <i class="ti ti-upload"></i> Import
                        </button>
                    @endif
                </div>
            </div>

            <div class="card-body">
                {{-- Form Import (collapsible) --}}
                <div class="collapse mb-3" id="importForm">
                    <div class="card card-body border rounded-3">
                        <form action="{{ route('admin.jadwal.import') }}" method="POST" enctype="multipart/form-data" class="row g-2 align-items-center">
                            @csrf
                            <div class="col">
                                <input type="file" name="file" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-success btn-sm" type="submit">
                                    <i class="ti ti-upload"></i> Import
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Tabel Jadwal --}}
                @if($kelasId)
                    <h5 class="fw-bold mb-3">Jadwal Kelas: {{ $kelasList->find($kelasId)->nama_kelas }}</h5>

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
                                                    <small class="badge bg-secondary">{{ $current->guru->nama ?? '-' }}</small>
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
                    <div class="alert alert-info">
                        <i class="ti ti-info-circle me-2"></i> Silakan pilih kelas terlebih dahulu untuk melihat jadwal.
                    </div>
                @endif
            </div>
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
