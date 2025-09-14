@extends('layouts.app')

@section('title', 'Kelola Kelas')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3 class="page-title">Kelola Kelas</h3>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <a href="{{ route('admin.kelas.create') }}" class="btn btn-primary my-3">
                <span class="ti ti-plus me-1"></span>
                Tambah Kelas
            </a>

            <div class="card card-body">
                <table class="table table-striped dataTable">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Kelas</th>
                            <th>Wali Kelas</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kelas as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_kelas }}</td>
                                <td>{{ $item->waliKelas ? $item->waliKelas->nama : '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.kelas.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                        <span class="ti ti-pencil"></span> Edit
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-danger"
                                       onclick="actionDelete('{{ route('admin.kelas.destroy', $item->id) }}')">
                                        <span class="ti ti-trash"></span> Hapus
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada data kelas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<form id="form-delete" action="" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
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

    function actionDelete(url) {
        Swal.fire({
            title: "Apakah kamu yakin?",
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, hapus saja!",
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-delete').attr('action', url);
                $('#form-delete').submit();
            }
        });
    }
</script>
@endpush
