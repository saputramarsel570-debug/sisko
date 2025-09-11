@extends('layouts.app')

@section('title', 'Halaman Keluhan & Saran Siswa')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3 class="page-title">Keluhan & Saran</h3>
            <a href="{{ route('siswa.keluhan.create') }}" class="btn btn-primary my-3">
                <span class="ti ti-plus me-1"></span>
                Tambah
            </a>

            <div class="card card-body">
                <table class="table table-striped dataTable">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($keluhan as $index => $keluhan)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $keluhan->judul }}</td>
                                <td>
                                    @if ($keluhan->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif ($keluhan->status == 'diterima')
                                        <span class="badge bg-success">Diterima</span>
                                    @else
                                        <span class="badge bg-secondary">Selesai</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('siswa.keluhan.show', $keluhan->id) }}" class="btn btn-sm btn-info">
                                        <span class="ti ti-eye"></span> Detail
                                    </a>
                                    <a href="{{ route('siswa.keluhan.edit', $keluhan->id) }}" class="btn btn-sm btn-warning">
                                        <span class="ti ti-pencil"></span> Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada keluhan & saran"></td>
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
    <script type='text/javascript'>
    $(function() {
        $('.dataTable').DataTable();
    });

    function actionDelete(url) {
        Swal.fire({
            title : "Apakah kamu yakin?",
            text : "Data yang dihapus tidak dapat dikembalikan!",
            icon : "warning",
            showCancelButton : true,
            confirmButtonText : "Ya, hapus saja!"
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-delete').attr('action', url);
                $('#form-delete').submit();
            }
        });
    }
    </script>
@endpush

