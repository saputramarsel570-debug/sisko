@extends('layouts.app')

@section('title', 'Halaman Jurnal Guru')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="page-title">Jurnal Guru</h3>

        <a href="{{ route('guru.jurnal.create') }}" class="btn btn-primary my-3">
            <span class="ti ti-plus me-1"></span>
            Tambah
        </a>

        <div class="card card-body">
            <table class="table table-striped dataTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Guru</th>
                        <th>Kelas</th>
                        <th>Mapel</th>
                        <th>Materi</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jurnal as $item) 
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ $item->guru->nama ?? '-' }}</td>
                            <td>{{ $item->kelas->nama_kelas ?? '-' }}</td>
                            <td>{{ $item->mapel }}</td>
                            <td>{{ $item->materi }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($item->catatan, 80) }}</td>
                            <td>
                                <div class="btn-group" role="">
                                    <a href="{{ route('guru.jurnal.show', $item->id) }}" class="btn btn-sm btn-secondary">
                                        <span class="ti ti-eye"></span>
                                    </a>
                                    <a href="{{ route('guru.jurnal.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                        <span class="ti ti-pencil"></span>
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-danger"
                                        onclick="actionDelete('{{ route('guru.jurnal.destroy', $item->id) }}')">
                                        <span class="ti ti-trash"></span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada jurnal</td>
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