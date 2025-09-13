@extends('layouts.app')

@section('title', 'Halaman Kelola User')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3 class="page-title">Halaman Kelola User</h3>

            <a href="{{ route('admin.users.create') }}" class="btn btn-primary my-3">
                <span class="ti ti-plus me-1"></span>
                Tambah
            </a>

            <div class="card card-body">
                <table class="table table-striped dataTable">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $user)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td><span class="badge bg-info">{{ ucfirst($user->role) }}</span></td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                        <span class="ti ti-pencil"></span> Edit
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-danger"
                                       onclick="actionDelete('{{ route('admin.users.destroy', $user->id) }}')">
                                        <span class="ti ti-trash"></span> Hapus
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada user</td>
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
    <script type='text/javascript'>
    $(function() {
        $('.dataTable').DataTable();
    });

    function actionDelete(url) {
        Swal.fire({
            title : "Apakah kamu yakin?",
            text : "Data yang dihapus tidak dapat dikembalikan!",
            icon : "warning",
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
