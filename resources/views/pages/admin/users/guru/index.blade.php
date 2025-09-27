@extends('layouts.app')

@section('title', 'Kelola Data Guru')

@section('content')
<div class="row">
    <div class="col-md-12">
        @if (session('success'))
            <div id="success" class="alert alert-solid-success d-flex align-items-center" role="alert">
                <span class="alert-icon rounded"><i class="ti ti-check"></i></span>
                {{ session('success') }}
            </div>
        @endif
        <h3 class="page-title">Kelola Data Guru</h3>

        <div class="d-flex justify-content-between align-items-center my-3">
            <a href="{{ route('admin.guru.create') }}" class="btn btn-primary">
                <i class="ti ti-plus"></i> Tambah Guru
            </a>
            <a href="{{ route('admin.guru.export') }}" class="btn btn-success">
                <i class="ti ti-download"></i> Export
            </a>
        </div>

        <div class="mb-3">
            <form action="{{ route('admin.guru.import') }}" method="POST" enctype="multipart/form-data" class="d-flex" style="max-width:400px;">
                @csrf
                <input type="file" name="file" class="form-control me-2" required>
                <button class="btn btn-success" type="submit">
                    <i class="ti ti-upload"></i> Import
                </button>
            </form>
        </div>

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
                                <a href="{{ route('admin.guru.show', $item->id) }}" class="btn btn-sm btn-primary" >
                                        <span class="ti ti-eye"></span> Detail
                                    </a>
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
