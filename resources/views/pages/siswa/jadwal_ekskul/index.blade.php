@extends('layouts.app-siswa')

@section('title', 'Kelola Jadwal Ekskul')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-12">

        @if (session('success'))
            <div id="success" class="alert alert-success alert-dismissible fade show shadow-sm rounded-4" role="alert">
                <i class="ti ti-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">

            <div class="card-header bg-primary bg-gradient text-white py-3">
                <h5 class="mb-0 fw-semibold d-flex align-items-center">
                    <i class="ti ti-calendar-event me-2 fs-5"></i> Kelola Jadwal Ekskul
                </h5>
            </div>

            <div class="card-body">

                <table class="table table-hover table-borderless align-middle dataTable">
                    <thead class="bg-light">
                        <tr class="text-center text-secondary fw-semibold">
                            <th style="width: 5%">No</th>
                            <th style="width: 35%">Ekskul</th>
                            <th style="width: 30%">Hari</th>
                            <th style="width: 15%">Aksi</th>
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
                                        $hariList = is_array($item->hari) ? $item->hari : [$item->hari];
                                    @endphp
                                    @foreach ($hariList as $h)
                                        <span class="badge rounded-pill bg-hari me-1 mb-1 px-3 py-2">
                                            <i class="ti ti-calendar me-1"></i> {{ $h }}
                                        </span>
                                    @endforeach
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('siswa.jadwal_ekskul.show', $item->id) }}"
                                       class="btn btn-primary btn-sm rounded-pill px-3">
                                        <i class="ti ti-eye"></i> Detail
                                    </a>
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
@endsection


@push('styles')
<link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />

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

    .btn-soft-primary {
        background-color: #e8f0ff;
        color: #0d6efd;
        border: 1px solid #cddfff;
        transition: 0.25s;
    }
    .btn-soft-primary:hover {
        background-color: #0d6efd;
        color: #fff;
    }

    thead tr th {
        background: #f8f9fa !important;
        border-bottom: 2px solid #e1e1e1 !important;
    }
</style>
@endpush


@push('scripts')
<script src="{{ asset('/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>

<script>
    $(function() {
        $('.dataTable').DataTable({
            pageLength: 5,
            responsive: true,
            language: {
                search: "🔍 Cari:",
                zeroRecords: "Tidak ada data ditemukan",
                info: "Menampilkan PAGE dari PAGES",
                infoEmpty: "Tidak ada data tersedia",
                infoFiltered: "(difilter dari total MAX data)"
            }
        });
    });
</script>
@endpush