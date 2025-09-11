@extends('layouts.app')

@section('title', 'Kelola Data Guru')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="page-title">Kelola Data Guru</h3>

        <a href="{{ route('admin.guru.create') }}" class="btn btn-primary my-3">
            <i class="ti ti-plus"></i> Tambah Guru
        </a>

        <div class="card card-body">
            <table class="table table-striped dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Mata Pelajaran</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guru as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->nip }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->mapel }}</td>
                            <td>{{ $item->user->email ?? '-' }}</td>
                            <td>
                                <a href="{{ route('admin.guru.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                    <i class="ti ti-pencil"></i> Edit
                                </a>
                                <a href="javascript:;" class="btn btn-sm btn-danger"
                                   onclick="actionDelete('{{ route('admin.guru.destroy', $item->id) }}')">
                                    <i class="ti ti-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data guru</td>
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
