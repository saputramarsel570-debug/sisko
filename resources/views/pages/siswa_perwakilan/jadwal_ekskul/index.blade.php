@extends('layouts.app')

@section('title', 'Kelola Jadwal Ekskul')

@section('content')
<div class="row">
    <div class="col-md-12">
        @if (session('success'))
            <div id="success" class="alert alert-solid-success d-flex align-items-center" role="alert">
                <span class="alert-icon rounded"><i class="ti ti-check"></i></span>
                {{ session('success') }}
            </div>
        @endif

        <h3 class="page-title">Kelola Jadwal Ekskul</h3>
        <div class="card card-body">
            <table class="table table-striped dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Ekskul</th>
                        <th>Hari</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwal as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->ekstrakurikuler->nama }}</td>
                            <td>
                                {{ is_array($item->hari) ? implode(', ', $item->hari) : $item->hari }}
                            </td>
                            <td>
                                <a href="{{ route('siswa_perwakilan.jadwal_ekskul.show', $item->id) }}" class="btn btn-sm btn-info">
                                    <i class="ti ti-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada jadwal ekskul</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
        $('.dataTable').DataTable();
    });
</script>
@endpush
