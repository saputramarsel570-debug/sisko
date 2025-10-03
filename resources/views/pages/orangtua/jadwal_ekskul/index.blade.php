@extends('layouts.app')

@section('title', 'Kelola Jadwal Ekskul')

@section('content')
<div class="row">
    <div class="col-md-12">
        @if (session('success'))
            <div id="success" class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="ti ti-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <h3 class="fw-bold text-black mb-3">
            <i class="ti ti-calendar-event"></i> Kelola Jadwal Ekskul
        </h3>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table table-hover align-middle dataTable">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Ekskul</th>
                            <th>Hari</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwal as $item)
                            <tr>
                                <td class="fw-bold">{{ $loop->iteration }}</td>
                                <td>
                                    <i class="ti ti-users text-primary me-1"></i>
                                    {{ $item->ekstrakurikuler->nama }}
                                </td>
                                <td>
                                    @php
                                        $hariList = is_array($item->hari) ? $item->hari : [$item->hari];
                                    @endphp
                                    @foreach($hariList as $h)
                                        <span class="badge bg-info text-dark me-1 mb-1">{{ $h }}</span>
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('orangtua.jadwal_ekskul.show', $item->id) }}" 
                                       class="btn btn-sm btn-primary">
                                        <i class="ti ti-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
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
        background-color: #f1f8ff !important;
        transition: 0.2s;
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
        });
    });
</script>
@endpush