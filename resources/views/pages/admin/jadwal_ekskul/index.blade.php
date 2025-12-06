@extends('layouts.app')

@section('title', 'Kelola Jadwal Ekskul')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-12">

        {{-- Notifikasi sukses --}}
        @if (session('success'))
      <div id="success" class="alert alert-solid-success d-flex align-items-center" role="alert">
        <span class="alert-icon rounded"><i class="ti ti-check"></i></span>
        {{ session('success') }}
      </div>
    @endif

        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">

            <div class="card-header bg-primary bg-gradient text-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold d-flex align-items-center">
                    <i class="ti ti-calendar-event me-2 fs-5"></i> Kelola Jadwal Ekskul
                </h5>

                <div class="d-flex">
                    <a href="{{ route('admin.jadwal_ekskul.create') }}" class="btn btn-light btn-sm rounded-pill px-3 me-2">
                        <i class="ti ti-plus"></i> Tambah
                    </a>

                    <a href="{{ route('admin.jadwal_ekskul.export') }}" class="btn btn-success btn-sm rounded-pill px-3">
                        <i class="ti ti-file-export"></i> Export
                    </a>
                </div>
            </div>

            <div class="card-body">

                {{-- Tabel --}}
                <table class="table table-hover table-borderless align-middle dataTable">
                    <thead class="bg-light">
                        <tr class="text-center text-secondary fw-semibold">
                            <th style="width: 5%">No</th>
                            <th style="width: 35%">Ekskul</th>
                            <th style="width: 30%">Hari</th>
                            <th style="width: 25%">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($jadwal as $item)
                            <tr class="rounded-3">
                                <td class="fw-bold text-center">{{ $loop->iteration }}</td>

                                <td class="fw-semibold text-dark">
                                    <i class="ti ti-users text-primary me-1"></i>
                                    {{ $item->ekstrakurikuler->nama }}
                                </td>

                                <td>
                                    @php
                                        $hariList = is_array($item->hari) ? $item->hari : explode(',', $item->hari);
                                    @endphp
                                    @foreach ($hariList as $h)
                                        <span class="badge rounded-pill bg-hari me-1 mb-1 px-3 py-2">
                                            <i class="ti ti-calendar me-1"></i> {{ $h }}
                                        </span>
                                    @endforeach
                                </td>

                                <td class="text-center td-aksi">
                                    <div class="action-buttons">

                                        <a href="{{ route('admin.jadwal_ekskul.show', $item->id) }}"
                                            class="btn btn-primary btn-sm rounded-pill px-2">
                                            <i class="ti ti-eye"></i> Lihat
                                        </a>

                                        <a href="{{ route('admin.jadwal_ekskul.edit', $item->id) }}"
                                            class="btn btn-warning btn-sm rounded-pill px-2">
                                            <i class="ti ti-pencil"></i> Edit
                                        </a>

                                        <button onclick="actionDelete('{{ route('admin.jadwal_ekskul.destroy', $item->id) }}')" 
                                            class="btn btn-danger btn-sm rounded-pill px-2">
                                            <i class="ti ti-trash"></i> Hapus
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="ti ti-info-circle"></i> Belum ada jadwal ekskul
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
        transition: all 0.25s ease;
    }

    .bg-hari {
        background: #eaf4ff !important;
        color: #0d6efd !important;
        border: 1px solid #b8daff !important;
        font-size: 13px;
    }

    .td-aksi {
        white-space: nowrap !important;
    }

    .action-buttons {
        display: flex;
        gap: 6px;
        justify-content: center;
        flex-wrap: nowrap !important; 
    }

    .action-buttons .btn {
        padding: 4px 10px !important; 
        font-size: 12px;
    }

    thead tr th {
        background: #f8f9fa !important;
        border-bottom: 2px solid #e1e1e1 !important;
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