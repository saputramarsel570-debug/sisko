@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Daftar Jurnal</h3>

    <a href="{{ route('guru.jurnal.create', ['kelas_id' => $kelasId]) }}" class="btn btn-primary">Tambah Jurnal</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kelas</th>
                <th>Mapel</th>
                <th>Jam</th>
                <th>Materi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jurnal as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $row->tanggal }}</td>
                    <td>{{ $row->kelas->nama_kelas }}</td>
                    <td>{{ $row->mapel->nama_mapel }}</td>
                    <td>{{ $row->jam_mulai }} - {{ $row->jam_selesai }}</td>
                    <td>{{ Str::limit($row->materi, 30) }}</td>
                    <td>
                        <a href="{{ route('guru.jurnal.show', $row->id) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('guru.jurnal.edit', $row->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">Belum ada jurnal</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $jurnal->links() }}
</div>
@endsection