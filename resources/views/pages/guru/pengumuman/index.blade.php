@extends('layouts.app')

@section('title', 'Halaman Pengumuman Guru')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="page-title">Pengumuman Guru</h3>

        <a href="{{ route('guru.pengumuman.create') }}" class="btn btn-primary my-3">
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
                            <td>{{ Str::limit($item->isi, 50) }}</td>
                            <td>{{ $item->user->name ?? 'Tidak diketahui' }}</td>
                            <td>
                                <a href="{{ route('guru.pengumuman.show', $item->id) }}" class="btn btn-sm btn-secondary">
                                    <span class="ti ti-eye"></span>
                                </a>
                                <a href="{{ route('guru.pengumuman.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                    <span class="ti ti-pencil"></span>
                                </a>
                                <a href="javascript:;" class="btn btn-sm btn-danger"
                                    onclick="actionDelete('{{ route('guru.pengumuman.destroy', $item->id) }}')">
                                    <span class="ti ti-trash"></span>
                                </a>
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
    </script>
@endpush