@extends('layouts.app')

@section('title', 'Halaman Kelola User')

@section('content')
<div class="row">
    <div class="col-md-12">
        @if (session('success'))
            <div id="success" class="alert alert-solid-success d-flex align-items-center" role="alert">
                <span class="alert-icon rounded"><i class="ti ti-check"></i></span>
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white rounded-top-4">
                <h4 class="mb-0 fw-bold"><i class="ti ti-users"></i> Kelola User</h4>
                <div>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-light btn-sm me-2">
                        <i class="ti ti-plus"></i> Tambah Admin
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle dataTable">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th width="200">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <img src="{{ $user->profile_photo ? asset('uploads/profile/' . $user->profile_photo) : asset('img/avatars/1.png') }}"
                                             alt="Foto {{ $user->name }}"
                                             class="rounded-circle shadow-sm"
                                             width="45" height="45"
                                             style="object-fit: cover;">
                                    </td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @php
                                            $badgeColors = [
                                                'admin' => 'danger',
                                                'guru' => 'success',
                                                'siswa' => 'primary',
                                                'orangtua' => 'warning'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $badgeColors[$user->role] ?? 'info' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.users.show', $user->id) }}"
                                           class="btn btn-sm btn-info">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                           class="btn btn-sm btn-warning">
                                            <i class="ti ti-pencil"></i>
                                        </a>
                                        <a href="javascript:;" class="btn btn-sm btn-danger"
                                           onclick="actionDelete('{{ route('admin.users.destroy', $user->id) }}')">
                                            <i class="ti ti-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada user</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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

    <style>
        .table > :not(caption) > * > * {
            vertical-align: middle;
        }

        /* Responsive untuk tampilan mobile */
        @media (max-width: 768px) {
            .table thead {
                display: none;
            }

            .table tbody tr {
                display: block;
                margin-bottom: 1rem;
                background: #fff;
                border-radius: 10px;
                box-shadow: 0 2px 6px rgba(0,0,0,0.05);
                padding: 1rem;
            }

            .table tbody td {
                display: flex;
                justify-content: space-between;
                padding: 0.4rem 0;
                font-size: 0.9rem;
                border-bottom: 1px dashed #eee;
            }

            .table tbody td:last-child {
                border-bottom: none;
            }

            .table tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #555;
            }

            .table tbody td img {
                width: 40px;
                height: 40px;
                border-radius: 50%;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script>
    $(function() {
        $('.dataTable').DataTable({
            responsive: true
        });
    });

    function actionDelete(url) {
        Swal.fire({
            title : "Apakah kamu yakin?",
            text : "Data yang dihapus tidak dapat dikembalikan!",
            icon : "warning",
            confirmButtonText : "Ya, hapus saja!",
            showCancelButton: true,
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $('#form-delete').attr('action', url);
                $('#form-delete').submit();
            }
        });
    }

    setTimeout(() => {
        let alert = document.getElementById('success');
        if (alert) {
            alert.style.transition = "opacity 0.5s ease";
            alert.style.opacity = 0;
            setTimeout(() => alert.remove(), 500);
        }
    }, 3000);
    </script>
@endpush
