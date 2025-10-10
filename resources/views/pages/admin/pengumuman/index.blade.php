@extends('layouts.app')

@section('title', 'Kelola Pengumuman')

@section('content')
<div class="row">
    <div class="col-md-12">

        {{-- Notifikasi sukses --}}
        @if (session('success'))
            <div id="success" class="alert alert-solid-success d-flex align-items-center" role="alert">
                <span class="alert-icon rounded"><i class="ti ti-check"></i></span>
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top-4">
                <h4 class="mb-0 fw-bold"><i class="ti ti-bell"></i> Kelola Pengumuman</h4>
                <a href="{{ route('admin.pengumuman.create') }}" class="btn btn-light btn-sm fw-semibold shadow-sm">
                    <i class="ti ti-plus"></i> Tambah Pengumuman
                </a>
            </div>

            <div class="card-body">
                {{-- Tabel Pengumuman --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center dataTable mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Isi</th>
                                <th>Dibuat Oleh</th>
                                <th width="180">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengumuman as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="fw-bold text-start">{{ $item->judul }}</td>
                                    <td class="text-start">{{ Str::limit($item->isi, 80) }}</td>
                                    <td>{{ $item->user->name ?? 'Tidak diketahui' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.pengumuman.show', $item->id) }}" 
                                               class="btn btn-sm btn-info text-white shadow-sm" 
                                               title="Lihat">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.pengumuman.edit', $item->id) }}" 
                                               class="btn btn-sm btn-warning text-white shadow-sm" 
                                               title="Edit">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger shadow-sm" 
                                                    title="Hapus"
                                                    onclick="actionDelete('{{ route('admin.pengumuman.destroy', $item->id) }}')">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada pengumuman</td>
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
@endpush

@push('scripts')
<script src="{{ asset('/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
<script src="{{ asset('/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script type="text/javascript">
$(function() {
    $('.dataTable').DataTable({
        pageLength: 10,
        ordering: false
    });
});

function actionDelete(url) {
    Swal.fire({
        title: "Apakah kamu yakin?",
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            $('#form-delete').attr('action', url);
            $('#form-delete').submit();
        }
    });
}

setTimeout(() => {
    let alert = document.getElementById('success');
    if (alert) {
        alert.style.transition = "opacity 0.5s ease";
        alert.style.opacity = 0;
        setTimeout(() => alert.remove(), 500);
    }
}, 3000);
</script>
@endpush