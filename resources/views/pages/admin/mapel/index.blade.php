@extends('layouts.app')

@section('title', 'Kelola Mata Pelajaran')

@section('content')
<div class="row">
    <div class="col-md-12">

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        {{-- Notifikasi sukses --}}
        @if (session('success'))
            <div id="success" class="alert alert-solid-success d-flex align-items-center" role="alert">
                <span class="alert-icon rounded"><i class="ti ti-check"></i></span>
                {{ session('success') }}
            </div>
        @endif

        @if (session('import_success') && session('import_errors'))
        <script>
            let html = "<p><b>{{ session('import_success') }} data berhasil diimport.</b></p>";
            html += "<p><b>Beberapa data gagal:</b></p>";
            html += "<ul style='text-align:left'>";
            @foreach(session('import_errors') as $failure)
                html += "<li><b>Baris {{ $failure->row() }}</b> : {{ implode(', ', $failure->errors()) }}</li>";
            @endforeach
            html += "</ul>";

            Swal.fire({
                icon: 'warning',
                title: 'Import Selesai Dengan Catatan',
                html: html,
            });
        </script>
        @endif

        @if (session('import_success') && !session('import_errors'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Import Berhasil',
                text: 'Berhasil menambahkan {{ session("import_success") }} data.',
            });
        </script>
        @endif

        @if (!session('import_success') && session('import_errors'))
        <script>
            let html = "<ul style='text-align:left'>";
            @foreach(session('import_errors') as $failure)
                html += "<li><b>Baris {{ $failure->row() }}</b> : {{ implode(', ', $failure->errors()) }}</li>";
            @endforeach
            html += "</ul>";

            Swal.fire({
                icon: 'error',
                title: 'Import Gagal!',
                html: html,
            });
        </script>
        @endif

        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top-4">
                <h4 class="mb-0 fw-bold"><i class="ti ti-book"></i> Kelola Mata Pelajaran</h4>
                <div>
                    <a href="{{ route('admin.mapel.create') }}" class="btn btn-light btn-sm me-2">
                        <i class="ti ti-plus"></i> Tambah Mapel
                    </a>
                    <a href="{{ route('admin.mapel.export') }}" class="btn btn-success btn-sm me-2">
                        <i class="ti ti-download"></i> Export
                    </a>
                    <a href="{{ route('admin.mapel.template') }}" class="btn btn-success btn-sm me-2">
                        <i class="ti ti-download"></i> Download Template Excel Untuk Import
                    </a>
                    <button class="btn btn-info btn-sm" data-bs-toggle="collapse" data-bs-target="#importForm">
                        <i class="ti ti-upload"></i> Import
                    </button>
                </div>
            </div>

            <div class="card-body">
                {{-- Form Import (collapsible) --}}
                <div class="collapse mb-3" id="importForm">
                    <div class="card card-body border rounded-3">
                        <form action="{{ route('admin.mapel.import') }}" method="POST" enctype="multipart/form-data" class="row g-2 align-items-center">
                            @csrf
                            <div class="col">
                                <input type="file" name="file" class="form-control" required>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-success" type="submit">
                                    <i class="ti ti-upload"></i> Import
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Tabel Mata Pelajaran --}}
                <table class="table table-striped table-hover align-middle dataTable">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Kode Mapel</th>
                            <th>Nama Mapel</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mapel as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><span class="badge bg-info">{{ $item->kode_mapel }}</span></td>
                                <td>{{ $item->nama_mapel }}</td>
                                <td>
                                    <a href="{{ route('admin.mapel.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                        <i class="ti ti-pencil"></i>
                                    </a>
                                    <a href="javascript:;" class="btn btn-sm btn-danger"
                                       onclick="actionDelete('{{ route('admin.mapel.destroy', $item->id) }}')">
                                        <i class="ti ti-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada data mata pelajaran</td>
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