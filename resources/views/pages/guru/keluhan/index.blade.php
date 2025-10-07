@extends('layouts.app-guru')

@section('title', 'Keluhan & Saran Siswa')

@section('content')
<div class="row">
    <div class="col-md-12">

        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="ti ti-message-dots me-2"></i> Keluhan & Saran Siswa / Orangtua</h4>
            </div>

            <div class="card-body bg-light rounded-bottom-4">
                <table class="table table-hover align-middle bg-white rounded shadow-sm dataTable">
                    <thead class="table-primary text-center">
                        <tr>
                            <th style="width: 5%">No</th>
                            <th>Nama Siswa</th>
                            <th>Kategori</th>
                            <th>Isi</th>
                            <th>Status</th>
                            <th>Balasan</th>
                            <th style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($keluhan as $item) 
                            <tr>
                                <td class="text-center fw-semibold">{{ $loop->iteration }}</td>
                                <td>{{ $item->user->name ?? '-' }}</td>
                                <td>{{ ucfirst($item->kategori) }}</td>
                                <td>{{ Str::limit($item->isi, 80) }}</td>
                                <td class="text-center">
                                    <span class="badge px-3 py-2 rounded-pill 
                                        @if($item->status == 'pending') bg-warning text-dark 
                                        @elseif($item->status == 'proses') bg-info text-dark 
                                        @elseif($item->status == 'selesai') bg-success 
                                        @else bg-secondary @endif">
                                        {{ ucfirst($item->status ?? 'pending') }}
                                    </span>
                                </td>
                                <td>{{ $item->balasan ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('guru.keluhan.show', $item->id) }}" class="btn btn-sm btn-secondary">
                                            <span class="ti ti-eye"></span>
                                        </a>
                                        <a href="{{ route('guru.keluhan.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                            <span class="ti ti-pencil"></span>
                                        </a>
                                        <a href="javascript:;" class="btn btn-sm btn-danger"
                                            onclick="actionDelete('{{ route('guru.keluhan.destroy', $item->id) }}')">
                                            <span class="ti ti-trash"></span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
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
        title :"Yakin mau dihapus?",
        text : "Data yang dihapus tidak dapat dikembalikan!",
        icon : "warning",
        showCancelButton : true,
        confirmButtonText : "Ya, hapus!"
    }).then((result) => {
        if (result.isConfirmed) {
            $('#form-delete').attr('action', url);
            $('#form-delete').submit();
        }
    });
}
</script>
@endpush