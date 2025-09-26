@extends('layouts.app')

@section('title', 'Kelola Kelas')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (session('success'))
                <div id="success" class="alert alert-solid-success d-flex align-items-center" role="alert">
                    <span class="alert-icon rounded"><i class="ti ti-check"></i></span>
                    {{ session('success') }}
                </div>
            @endif
            <h3 class="page-title">Kelola Kelas</h3>

            <div class="d-flex justify-content-between align-items-center my-3">
                <a href="{{ route('admin.kelas.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus"></i> Tambah Kelas
                </a>
                <form action="{{ route('admin.kelas.import') }}" method="POST" enctype="multipart/form-data" class="d-flex">
                    @csrf
                    <input type="file" name="file" class="form-control me-2" style="max-width: 250px;" required>
                    <button class="btn btn-success" type="submit">
                        <i class="ti ti-upload"></i> Import
                    </button>
                </form>
            </div>

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

    setTimeout(function () {
        let alert = document.getElementById('success');
        if (alert) {

            alert.style.transition = "opacity 0.5s ease";
            alert.style.opacity = 0;

            setTimeout(() => alert.remove(), 500);
        }
    }, 3000);

</script>
@endpush
