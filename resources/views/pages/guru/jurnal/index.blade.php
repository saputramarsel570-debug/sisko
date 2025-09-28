@extends('layouts.app')

@section('title', 'Jurnal Guru')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="page-title">Jurnal Guru - {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}</h3>

        <div class="card card-body">
            <form method="GET" action="{{ route('guru.jurnal.index') }}" class="row g-2 mb-3">
                <div class="col-md-4">
                    <select name="kelas_id" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-8 text-end">
                    <a href="{{ route('guru.jurnal.create') }}" class="btn btn-primary btn-sm">+ Tambah Jurnal</a>
                    <a href="{{ route('guru.jurnal.index', ['tanggal' => \Carbon\Carbon::parse($tanggal)->subDay()->toDateString()]) }}" class="btn btn-outline-secondary btn-sm">Sebelumnya</a>
                    <a href="{{ route('guru.jurnal.index', ['tanggal' => \Carbon\Carbon::parse($tanggal)->addDay()->toDateString()]) }}" class="btn btn-outline-secondary btn-sm">Berikutnya</a>
                </div>
            </form>

            @if($jurnal->isEmpty())
                <div class="alert alert-info">
                    Belum ada jurnal pada tanggal ini.
                </div>
            @else
                <table class="table table-striped dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Materi</th>
                            <th>Catatan</th>
                            <th>Guru</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jurnal as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->kelas->nama_kelas ?? '-' }}</td>
                                <td>{{ $item->mapel ?? '-' }}</td>
                                <td>{{ $item->materi }}</td>
                                <td>{{ $item->catatan ?? '-' }}</td>
                                <td>{{ $item->guru->nama ?? '-' }}</td>
                                <td>
                                    <div class="btn-group" role="">
                                        <a href="{{ route('guru.jurnal.show', $item->id) }}" class="btn btn-sm btn-secondary">
                                            <span class="ti ti-eye"></span>
                                        </a>
                                        <a href="{{ route('guru.jurnal.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                            <span class="ti ti-pencil"></span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endpush

@push('scripts')
    <script src="{{ asset('/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script type="text/javascript">
    $(function() {
        $('.dataTable').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50]
        });
    });
    </script>
@endpush