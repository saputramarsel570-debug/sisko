@extends('layouts.app')

@section('title', 'Jadwal Pelajaran')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="page-title">Jadwal Pelajaran</h3>

        {{-- Filter kelas --}}
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
                <a href="{{ route('admin.jadwal.edit', $kelasId) }}" class="btn btn-warning btn-sm">
                    <i class="ti ti-edit"></i> Edit Jadwal
                </a>
            </div>

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Hari</th>
                                @for($jam = 1; $jam <= 10; $jam++)
                                    <th>Jam {{ $jam }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(['Senin','Selasa','Rabu','Kamis','Jumat'] as $hari)
                                <tr>
                                    <td><strong>{{ $hari }}</strong></td>
                                    @for($jam = 1; $jam <= 10; $jam++)
                                        <td>
                                            @if(isset($jadwalByHari[$hari][$jam]))
                                                <div>
                                                    <strong>{{ $jadwalByHari[$hari][$jam]->mataPelajaran->nama_mapel }}</strong><br>
                                                    <small>{{ $jadwalByHari[$hari][$jam]->guru->nama ?? '-' }}</small>
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    @endfor
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
