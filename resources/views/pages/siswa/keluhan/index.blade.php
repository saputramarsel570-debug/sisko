@extends('layouts.app-siswa')

@section('title', 'Keluhan & Saran')

@section('content')
<div class="row">
    <div class="col-md-12">
        @if (session('success'))
            <div id="success" class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="ti ti-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
                <h4 class="mb-0 fw-semibold">
                    <i class="ti ti-message-2 me-2"></i> Keluhan & Saran
                </h4>
                <a href="{{ route('siswa.keluhan.create') }}" class="btn btn-light btn-sm fw-semibold shadow-sm">
                    <i class="ti ti-plus"></i> Tambah
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle dataTable">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Kategori</th>
                                <th>Isi</th>
                                <th>Status</th>
                                <th>Balasan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($keluhan as $item)
                                <tr>
                                    <td class="fw-bold">{{ $loop->iteration }}</td>
                                    <td>{{ ucfirst($item->kategori) }}</td>
                                    <td>{{ Str::limit($item->isi, 50) }}</td>
                                    <td>
                                        @if($item->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($item->status == 'proses')
                                            <span class="badge bg-info text-dark">Proses</span>
                                        @else
                                            <span class="badge bg-success">Selesai</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->balasan ?? '-' }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('siswa.keluhan.show', $item->id) }}" 
                                               class="btn btn-sm btn-secondary">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            <a href="{{ route('siswa.keluhan.edit', $item->id) }}" 
                                               class="btn btn-sm btn-primary">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="actionDelete('{{ route('siswa.keluhan.destroy', $item->id) }}')">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-3">
                                        <i class="ti ti-info-circle"></i> Belum ada data keluhan
                                    </td>
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

    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ asset('/vendor/libs/sweetalert2/sweetalert2.css') }}" />
<style>
    .table-hover tbody tr:hover {
        background-color: #f1f8ff !important;
        transition: 0.2s;
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
<script src="{{ asset('/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
<script>
    $(function() {
        $('.dataTable').DataTable({
            pageLength: 5,
            responsive: true,
        });
    });

    function actionDelete(url) {
        Swal.fire({
            title: "Yakin mau dihapus?",
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: "warning",
            showCancelButton: true,
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