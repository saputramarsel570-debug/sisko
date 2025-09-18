@extends('layouts.app')

@section('title', 'Halaman Keluhan & Saran')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3 class="page-title">Halaman Keluhan & Saran</h3>

            <a href="{{ route('orangtua.keluhan.create') }}" class="btn btn-primary my-3">
                <span class="ti ti-plus me-1"></span>
                Tambah
            </a>

            <div class="card card-body">
                <table class="table table-striped dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Isi</th>
                            <th>Status</th>
                            <th>Balasan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($keluhan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ ucfirst($item->kategori) }}</td>
                                <td>{{ Str::limit($item->isi, 50) }}</td>
                                <td>
                                    @if($item->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($item->status == 'proses')
                                        <span class="badge bg-primary">Proses</span>
                                    @else
                                        <span class="badge bg-success">Selesai</span>
                                    @endif
                                </td>
                                <td>{{ $item->balasan ?? '-' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                    <div class="gap-2 d-flex justify-content-betwen">
                                    <a href="{{ route('orangtua.keluhan.show', $item->id) }}" class="btn btn-sm btn-secondary">
                                        <span class="ti ti-eye"></span>
                                    </a>
                                    <a href="{{ route('orangtua.keluhan.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                        <span class="ti ti-pencil"></span>
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-danger"
                                        onclick="actionDelete('{{ route('orangtua.keluhan.destroy', $item->id) }}')">
                                        <span class="ti ti-trash"></span>
                                    </a>
                                    </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
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
    <script type='text/javascript'>
        $(function() {
            $('.dataTable').DataTable();
        });

        function actionDelete(url) {
            Swal.fire({
                title: "Yakin mau dihapus?",
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, hapus!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-delete').attr('action', url);
                    $('#form-delete').submit();
                }
            });
        }
    </script>
@endpush