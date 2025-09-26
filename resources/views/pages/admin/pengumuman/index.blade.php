@extends('layouts.app')

@section('title', 'Halaman Pengumuman Admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        @if (session('success'))
            <div id="success" class="alert alert-solid-success d-flex align-items-center" role="alert">
                <span class="alert-icon rounded"><i class="ti ti-check"></i></span>
                {{ session('success') }}
            </div>
        @endif
        <h3 class="page-title">Pengumuman Admin</h3>

        <a href="{{ route('admin.pengumuman.create') }}" class="btn btn-primary my-3">
            <span class="ti ti-plus me-1"></span>
            Tambah
        </a>

        <div class="card card-body">
            <table class="table table-striped dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Isi</th>
                        <th>Dibuat Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengumuman as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->judul }}</td>
                            <td>{{ Str::limit($item->isi, 80) }}</td>
                            <td>{{ $item->user->name ?? 'Tidak diketahui' }}</td>
                            <td>
                                <div class="btn-group" role="">
                                <a href="{{ route('admin.pengumuman.show', $item->id) }}" class="btn btn-sm btn-secondary">
                                    <span class="ti ti-eye"></span>
                                </a>
                                <a href="{{ route('admin.pengumuman.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                    <span class="ti ti-pencil"></span>
                                </a>
                                <a href="javascript:;" class="btn btn-sm btn-danger"
                                    onclick="actionDelete('{{ route('admin.pengumuman.destroy', $item->id) }}')">
                                    <span class="ti ti-trash"></span>
                                </a>
                             </div>
                            </td>
                        </tr>
                    @endforeach
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
            title :"Yakin mau dihapus?",
            text : "Data yang dihapus tidak dapat dikembalikan!",
            icon : "warning",
            showCancelButton : true,
            confirmButtonText : "Ya, hapus!"
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
