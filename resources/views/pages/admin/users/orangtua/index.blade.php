@extends('layouts.app')

@section('title', 'Kelola Orang Tua')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (session('success'))
                <div id="success" class="alert alert-solid-success d-flex align-items-center" role="alert">
                    <span class="alert-icon rounded"><i class="ti ti-check"></i></span>
                    {{ session('success') }}
                </div>
            @endif
            <h3 class="page-title">Kelola Orang Tua</h3>

            <a href="{{ route('admin.orangtua.create') }}" class="btn btn-primary my-3">
                <span class="ti ti-plus me-1"></span>
                Tambah Orang Tua
            </a>

            <form action="{{ route('admin.orangtua.index') }}" method="GET" class="row g-2 mb-3">
                <div class="col-md-4">
                    <select name="kelas_id" id="kelas_id" class="form-select">
                        <option value="">-- Semua Kelas --</option>
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id }}" {{ $kelasId == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama orang tua / siswa / NIS" value="{{ $search }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-secondary">Filter</button>
                </div>
            </form>

            <div class="card card-body">
                <table class="table table-striped dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Orang Tua</th>
                            <th>No HP</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orangtua as $index => $ot)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $ot->nama }}</td>
                                <td>{{ $ot->no_hp }}</td>
                                <td>{{ $ot->siswa->nama ?? '-' }}</td>
                                <td>{{ $ot->siswa->kelas->nama_kelas ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.orangtua.show', $ot->id) }}" class="btn btn-sm btn-primary" >
                                        <span class="ti ti-eye"></span> Detail
                                    </a>
                                    <a href="{{ route('admin.orangtua.edit', $ot->id) }}" class="btn btn-sm btn-warning">
                                        <span class="ti ti-pencil"></span> Edit
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-danger"
                                       onclick="actionDelete('{{ route('admin.orangtua.destroy', $ot->id) }}')">
                                        <span class="ti ti-trash"></span> Hapus
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data orang tua</td>
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
            title: "Apakah kamu yakin?",
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, hapus saja!",
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
