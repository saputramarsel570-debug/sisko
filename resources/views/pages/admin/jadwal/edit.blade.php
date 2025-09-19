@extends('layouts.app')

@section('title', 'Edit Jadwal Pelajaran')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="page-title">Edit Jadwal - {{ $kelas->nama_kelas }}</h3>

        <form action="{{ route('admin.jadwal.updateSchedule', $kelas->id) }}" method="POST">
            @csrf

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
                                    @for($jam = 1; $jam <= 10; $jam++)
                                        @php
                                            $data = $jadwalByHari[$hari][$jam] ?? null;
                                        @endphp
                                        <td>
                                            <select name="jadwal[{{ $hari }}][{{ $jam }}][mapel_id]" class="form-select w-100 text-dark" style="min-width: 150px;">
                                                <option value="">- Mapel -</option>
                                                @foreach($mapel as $m)
                                                    <option value="{{ $m->id }}" {{ $data && $data->mata_pelajaran_id == $m->id ? 'selected' : '' }}>
                                                        {{ $m->nama_mapel }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <select name="jadwal[{{ $hari }}][{{ $jam }}][guru_id]" class="form-select w-100 text-dark mt-1" style="min-width: 150px;">
                                                <option value="">- Guru -</option>
                                                @foreach($guru as $g)
                                                    <option value="{{ $g->id }}" {{ $data && $data->guru_id == $g->id ? 'selected' : '' }}>
                                                        {{ $g->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="ti ti-device-floppy"></i> Simpan Jadwal
                </button>
                <a href="{{ route('admin.jadwal.index', ['kelas_id' => $kelas->id]) }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
