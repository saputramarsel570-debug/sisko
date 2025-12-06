@extends('layouts.app')

@section('title', 'Kelola Ekstrakurikuler')

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
                <h4 class="mb-0 fw-bold"><i class="ti ti-trophy"></i> Kelola Ekstrakurikuler</h4>
                <div>
                    <a href="{{ route('admin.ekskul.create') }}" class="btn btn-light btn-sm me-2">
                        <i class="ti ti-plus"></i> Tambah Ekskul
                    </a>
                    <a href="{{ route('admin.ekskul.export') }}" class="btn btn-success btn-sm">
                        <i class="ti ti-file-export"></i> Export
                    </a>
                </div>
            </div>

            <div class="card-body">
                {{-- Tabel Ekstrakurikuler --}}
                <table class="table table-hover table-borderless align-middle dataTable">
                    <thead class="bg-light">
                        <tr class="text-center text-secondary fw-semibold">
                            <th style="width: 5%">No</th>
                            <th style="width: 15%">Foto</th>
                            <th style="width: 25%">Nama Ekstrakurikuler</th>
                            <th style="width: 20%">Pembina</th>
                            <th style="width: 25%">Deskripsi</th>
                            <th style="width: 15%">Aksi</th>
                        </tr>
                    </thead>
                
                    <tbody>
                        @forelse($ekskul as $item)
                            <tr>

                                {{-- NOMOR --}}
                                <td class="fw-bold text-center">{{ $loop->iteration }}</td>
                
                                {{-- FOTO --}}
                                <td class="text-center">
                                    @if ($item->foto)
                                        <img src="{{ asset('storage/' . $item->foto) }}"
                                             class="rounded-3 shadow-sm ekskul-img-table"
                                             alt="{{ $item->nama }}">
                                    @else
                                        <span class="badge bg-secondary">Tidak ada</span>
                                    @endif
                                </td>
                
                                {{-- NAMA --}}
                                <td class="fw-semibold text-dark">
                                    <i class="ti ti-trophy text-primary me-1"></i>
                                    {{ $item->nama }}
                                </td>
                
                                {{-- PEMBINA --}}
                                <td>
                                    <span class="badge bg-pembina px-3 py-2">
                                        <i class="ti ti-user me-1"></i>
                                        {{ $item->nama_pembina ?? 'Tidak ada' }}
                                    </span>
                                </td>
                
                                {{-- DESKRIPSI --}}
                                <td class="text-muted">
                                    {{ Str::limit($item->deskripsi, 60) }}
                                </td>
                
                                {{-- AKSI --}}
                                <td class="text-center aksi-nowrap">
                                    <div class="d-flex justify-content-center gap-2 flex-nowrap">

                                        <a href="{{ route('admin.ekskul.show', $item->id) }}"
                                           class="btn btn-sm btn-primary rounded-pill px-3">
                                            <i class="ti ti-eye"></i>
                                        </a>
                    
                                        <a href="{{ route('admin.ekskul.edit', $item->id) }}"
                                           class="btn btn-sm btn-warning rounded-pill px-3">
                                            <i class="ti ti-pencil"></i>
                                        </a>
                    
                                        <button onclick="actionDelete('{{ route('admin.ekskul.destroy', $item->id) }}')"
                                                class="btn btn-sm btn-danger rounded-pill px-3">
                                            <i class="ti ti-trash"></i>
                                        </button>

                                    </div>
                                </td>
                
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="ti ti-info-circle"></i> Belum ada data ekstrakurikuler
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
        .table-hover tbody tr:hover {
            background-color: #f5f9ff !important;
            transition: 0.25s ease;
        }

        .ekskul-img-table {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border: 2px solid #e5ebff;
            transition: 0.25s;
        }

        .ekskul-img-table:hover {
            transform: scale(1.07);
            border-color: #bcd2ff;
        }

        .bg-pembina {
            background: #eef4ff !important;
            color: #0d6efd !important;
            border: 1px solid #cfe0ff !important;
            font-size: 13px;
        }

        thead tr th {
            background: #f8f9fa !important;
            border-bottom: 2px solid #e1e1e1 !important;
        }

        .aksi-nowrap {
            white-space: nowrap !important;
        }

        .aksi-nowrap .btn {
            min-width: 35px;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script type="text/javascript">
    $(function() {
        $('.dataTable').DataTable({
            responsive: true
        });
    });

    function actionDelete(url) {
        Swal.fire({
            title : "Apakah kamu yakin?",
            text : "Data yang dihapus tidak dapat dikembalikan!",
            icon : "warning",
            showCancelButton: true,
            confirmButtonText : "Ya, hapus saja!",
            cancelButtonText : "Batal"
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