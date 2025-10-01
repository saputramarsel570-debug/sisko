@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Detail Jurnal</h3>

    <ul class="list-group">
        <li class="list-group-item"><strong>Kelas:</strong> {{ $jurnal->kelas->nama_kelas }}</li>
        <li class="list-group-item"><strong>Mapel:</strong> {{ $jurnal->mapel->nama_mapel }}</li>
        <li class="list-group-item"><strong>Guru:</strong> {{ $jurnal->guru->nama }}</li>
        <li class="list-group-item"><strong>Tanggal:</strong> {{ $jurnal->tanggal }}</li>
        <li class="list-group-item"><strong>Jam:</strong> {{ $jurnal->jam_mulai }} - {{ $jurnal->jam_selesai }}</li>
        <li class="list-group-item"><strong>Materi:</strong> {{ $jurnal->materi }}</li>
        <li class="list-group-item"><strong>Catatan:</strong> {{ $jurnal->catatan }}</li>
    </ul>

    <a href="{{ route('guru.jurnal.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection