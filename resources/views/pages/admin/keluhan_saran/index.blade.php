@extends('layouts.app')

@section('title', 'Kelola Keluhan & Saran')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (session('success'))
                <div id="success" class="alert alert-solid-success d-flex align-items-center" role="alert">
                    <span class="alert-icon rounded"><i class="ti ti-check"></i></span>
                    {{ session('success') }}
                </div>
            @endif
            <h3 class="page-title">Kelola Keluhan & Saran</h3>

            <div class="card card-body table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Pengirim</th>
                            <th>Kategori</th>
                            <th>Isi</th>
                            <th>Status</th>
                            <th>Dikirim</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($keluhanSaran as $index => $item)
                        <tr>
                            <td>{{ $index + $keluhanSaran->firstItem() }}</td>
                            <td>{{ $item->user->name ?? '-' }}</td>
                            <td><span class="badge bg-{{ $item->kategori == 'keluhan' ? 'danger' : 'info' }}">{{ ucfirst($item->kategori) }}</span></td>
                            <td class="text-start">{{ Str::limit($item->isi, 50) }}</td>
                            <td>
                            @if ($item->status == 'pending')
                                <span class="badge bg-secondary">Pending</span>
                            @elseif ($item->status == 'proses')
                                <span class="badge bg-warning text-dark">Proses</span>
                            @else
                                <span class="badge bg-success">Selesai</span>
                            @endif
                            </td>
                            <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.keluhan_saran.show', $item->id) }}" class="btn btn-sm btn-info">
                                    <i class="ti ti-eye"></i> Lihat
                                </a>
                                <a href="{{ route('admin.keluhan_saran.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                    <i class="ti ti-edit"></i> Edit
                                </a>
                                <a href="javascript:;" class="btn btn-sm btn-danger"
                                   onclick="actionDelete('{{ route('admin.keluhan_saran.destroy', $item->id) }}')">
                                    <i class="ti ti-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada keluhan atau saran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $keluhanSaran->links() }}
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
