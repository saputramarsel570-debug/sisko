@extends('layouts.app')

@section('title', 'Kelola Siswa')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (session('success'))
                <div id="success" class="alert alert-solid-success d-flex align-items-center" role="alert">
                    <span class="alert-icon rounded"><i class="ti ti-check"></i></span>
                    {{ session('success') }}
                </div>
            @endif
            <h3 class="page-title">Halaman Kelola Siswa</h3>

            <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary my-3">
                <span class="ti ti-plus me-1"></span>
                Tambah Siswa
            </a>

            <div class="mb-3">
                <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data" class="d-flex">
                    @csrf
                    <input type="file" name="file" class="form-control me-2" style="max-width: 250px;" required>
                    <button class="btn btn-success" type="submit">
                        <i class="ti ti-upload"></i> Import Siswa & Ortu
                    </button>
                </form>
            </div>

            <form action="{{ route('admin.siswa.index') }}" method="GET" class="mb-3">
                <div class="row g-2 align-items-center">
                    <div class="col-md-3">
                        <select name="kelas_id" id="kelas_id" class="form-select" onchange="this.form.submit()">
                            <option value="">--Semua Kelas--</option>
                            @foreach ($kelasList as $kelas)
                                <option value="{{ $kelas->id }}" {{ $kelasId == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="role" id="role" class="form-select" onchange="this.form.submit()">
                            <option value="">--Semua Role--</option>
                            <option value="siswa" {{ request('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                            <option value="siswa_perwakilan" {{ request('role') == 'siswa_perwakilan' ? 'selected' : '' }}>Siswa Perwakilan</option>
                        </select>
                    </div>
                </div>
            </form>

            <div class="card">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Alamat</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($siswa as $index => $row)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $row->nis }}</td>
                                <td>{{ $row->nama }}</td>
                                <td>{{ $row->kelas ? $row->kelas->nama_kelas : '-' }}</td>
                                <td>{{ $row->alamat ?? '-' }}</td>
                                <td>
                                    @if($row->user && $row->user->role == 'siswa_perwakilan')
                                        <span class="badge bg-success">Perwakilan</span>
                                    @else
                                        <span class="badge bg-secondary">Siswa</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.siswa.show', $row->id) }}" class="btn btn-sm btn-primary" >
                                        <span class="ti ti-eye"></span> Detail
                                    </a>
                                    <a href="{{ route('admin.siswa.edit', $row->id) }}" class="btn btn-sm btn-warning">
                                        <span class="ti ti-pencil"></span> Edit
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-danger"
                                       onclick="actionDelete('{{ route('admin.siswa.destroy', $row->id) }}')">
                                        <span class="ti ti-trash"></span> Hapus
                                    </a>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data siswa</td>
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
            title : "Apakah kamu yakin?",
            text : "Data yang dihapus tidak dapat dikembalikan!",
            icon : "warning",
            confirmButtonText : "Ya, hapus saja!"
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
