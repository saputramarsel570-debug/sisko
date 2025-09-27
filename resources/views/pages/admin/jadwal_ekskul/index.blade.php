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

        <div class="d-flex justify-content-between align-items-center my-3">
            <a href="{{ route('admin.jadwal_ekskul.create') }}" class="btn btn-primary">
                <i class="ti ti-plus"></i> Tambah Jadwal Ekskul
            </a>
            <a href="{{ route('admin.jadwal_ekskul.export') }}" class="btn btn-success">
                <i class="ti ti-file-export"></i> Export Excel
            </a>
        </div>

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
                                {{-- tampilkan array hari dengan implode --}}
                                {{ is_array($item->hari) ? implode(', ', $item->hari) : $item->hari }}
                            </td>
                            <td>
                                <a href="{{ route('admin.jadwal_ekskul.show', $item->id) }}" class="btn btn-sm btn-info">
                                    <i class="ti ti-eye"></i> Detail
                                </a>
                                <a href="{{ route('admin.jadwal_ekskul.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                    <i class="ti ti-pencil"></i> Edit
                                </a>
                                <a href="javascript:;" class="btn btn-sm btn-danger"
                                   onclick="actionDelete('{{ route('admin.jadwal_ekskul.destroy', $item->id) }}')">
                                    <i class="ti ti-trash"></i> Hapus
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
