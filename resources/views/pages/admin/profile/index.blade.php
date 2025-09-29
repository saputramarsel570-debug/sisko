@extends('layouts.app')

@section('title', 'Profil Admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">

            @if (session('success'))
                <div id="success" class="alert alert-success d-flex align-items-center shadow-sm rounded-3" role="alert">
                    <i class="ti ti-check me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger shadow-sm rounded-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row g-4">
                <!-- Data Identitas -->
                <div class="col-md-6">
                    <div class="card shadow-lg border-0 rounded-4">
                        <div class="card-header bg-primary text-white rounded-top-4">
                            <h4 class="mb-0 fw-bold"><i class="ti ti-user"></i> Data Identitas</h4>
                        </div>
                        <div class="card-body text-center">
                            <img src="{{ $user->profile_photo ? asset('uploads/profile/' . $user->profile_photo) : 'https://via.placeholder.com/150' }}"
                                 alt="Foto Profil"
                                 class="rounded-circle shadow mb-3"
                                 style="width: 130px; height: 130px; object-fit: cover;">

                            <form action="{{ route('admin.profile.photo') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                                @csrf
                                <div class="input-group input-group-sm">
                                    <input type="file" name="profile_photo" id="profile_photo"
                                           class="form-control" accept="image/*" required>
                                    <button type="submit" class="btn btn-sm btn-success">
                                        <i class="ti ti-camera"></i> Ganti Foto
                                    </button>
                                </div>
                            </form>

                            <table class="table table-bordered text-start">
                                <tr>
                                    <th width="40%">Nama</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td>{{ ucfirst($user->role) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Ganti Password -->
                <div class="col-md-6">
                    <div class="card shadow-lg border-0 rounded-4">
                        <div class="card-header bg-warning text-dark rounded-top-4">
                            <h4 class="mb-0 fw-bold"><i class="ti ti-lock"></i> Ganti Password</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.profile.password') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Password Lama</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">Password Baru</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-warning text-dark fw-bold">
                                        <i class="ti ti-refresh"></i> Ganti Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
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
