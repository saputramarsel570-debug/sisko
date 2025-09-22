@extends('layouts.app')

@section('title', 'Absensi Kelas')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h4 class="mb-0">Isi Absensi</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('siswa_perwakilan.absensi.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Kelas</label>
                <input type="text" class="form-control" value="{{ $kelas->nama_kelas }}" disabled>
            </div>

            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th width="150">Status</th>
                        <th width="250">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswaKelas as $siswa)
                        <tr>
                            <td>{{ $siswa->nama }}</td>
                            <td>
                                <select name="absensi[{{ $siswa->id }}][status]" class="form-select" required>
                                    <option value="hadir">Hadir</option>
                                    <option value="izin">Izin</option>
                                    <option value="sakit">Sakit</option>
                                    <option value="alfa">Alfa</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="absensi[{{ $siswa->id }}][keterangan]" class="form-control" placeholder="Opsional">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">SIMPAN</button>
            </div>
        </form>
    </div>
</div>
@endsection