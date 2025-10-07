@extends('layouts.app-guru')

@section('title', 'Halaman Pengumuman Guru')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="ti ti-megaphone"></i> Pengumuman Guru</h4>
                <a href="{{ route('guru.pengumuman.create') }}" class="btn btn-light btn-sm text-primary fw-semibold shadow-sm">
                    <i class="ti ti-plus"></i> Tambah Pengumuman
                </a>
            </div>

            <div class="card-body bg-white rounded-bottom-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-primary text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th width="20%">Judul</th>
                                <th width="35%">Isi</th>
                                <th width="20%">Dibuat Oleh</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengumuman as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $item->judul }}</td>
                                    <td>{{ Str::limit($item->isi, 80) }}</td>
                                    <td>{{ $item->user->name ?? 'Tidak diketahui' }}</td>
                                    <td class="text-center">
                                        <div class="btn-group" role="">
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
                                         </div>
            
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">
                                        Belum ada data pengumuman.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
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
<style>
    table.table-hover tbody tr:hover {
        background-color: #f0f6ff !important;
        transition: background-color 0.2s ease-in-out;
    }
</style>
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
        title: "Yakin mau dihapus?",
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal",
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33"
    }).then((result) => {
        if (result.isConfirmed) {
            $('#form-delete').attr('action', url);
            $('#form-delete').submit();
        }
    });
}
</script>
@endpush