@extends('layouts.app')

@section('title', 'Jurnal Guru')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">

        <form method="GET" action="{{ route('guru.jurnal.index') }}" class="mb-3">
            <div class="row g-2 align-items-center">
                <div class="col-md-6">
                    <select name="kelas_id" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ $kelasId == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>

        @if(!$kelasId)
            <div class="alert alert-info">
                Silakan pilih kelas untuk melihat daftar jurnal.
            </div>
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Jurnal Guru</h4>
                <a href="{{ route('guru.jurnal.create') }}" class="btn btn-primary btn-sm">Tambah Jurnal</a>
            </div>
        @endif


        @if($kelasId && $jurnal->isEmpty())
            <div class="alert alert-warning">
                Belum ada untuk kelas ini.
            </div>
        @endif

        @if($jurnal->isNotEmpty())
        <div class="card card-body">
            <table class="table table-striped dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Kelas</th>
                        <th>Guru</th>
                        <th>Mata Pelajaran</th>
                        <th>Materi</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jurnal as $i => $item)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $item->kelas->nama_kelas ?? '-' }}</td>
                        <td>{{ $item->guru->nama ?? '-' }}</td>
                        <td>{{ $item->mapel ?? '-' }}</td>
                        <td>{{ $item->materi }}</td>
                        <td>{{ $item->catatan ?? '-' }}</td>
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
        </div>
        @endif
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
</script>
@endpush