@extends('layouts.app-siswa')

@section('title', 'Kelola Jadwal Ekskul')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-12">
        @if (session('success'))
            <div id="success" class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="ti ti-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-primary text-white d-flex align-items-center py-3">
                <h5 class="mb-0 fw-semibold">
                    <i class="ti ti-calendar-event me-2"></i> Kelola Jadwal Ekskul
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-hover align-middle dataTable">
                    <thead class="table-light border-bottom">
                        <tr class="text-center">
                            <th style="width: 5%;">No</th>
                            <th style="width: 35%;">Ekskul</th>
                            <th style="width: 30%;">Hari</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwal as $item)
                            <tr>
                                <td class="fw-bold text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <i class="ti ti-users text-primary me-1"></i>
                                    {{ $item->ekstrakurikuler->nama }}
                                </td>
                                <td>
                                    @php
                                        $hariList = is_array($item->hari) ? $item->hari : [$item->hari];
                                    @endphp
                                    @foreach($hariList as $h)
                                        <span class="badge bg-info-subtle text-dark border border-info me-1 mb-1 px-3 py-2">
                                            {{ $h }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('siswa.jadwal_ekskul.show', $item->id) }}" 
                                        class="btn btn-sm btn-primary">
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
        background-color: #f0f7ff !important;
        transition: all 0.2s ease-in-out;
    }
    .badge.bg-info-subtle {
        background-color: #e7f5ff !important;
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
                search: "Cari:",
                zeroRecords: "Tidak ada data ditemukan",
                info: "Menampilkan PAGE dari PAGES",
                infoEmpty: "Tidak ada data tersedia",
                infoFiltered: "(difilter dari total MAX data)"
            }
        });
    });
</script>
@endpush