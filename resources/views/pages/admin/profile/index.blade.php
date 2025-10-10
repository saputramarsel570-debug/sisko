@extends('layouts.app')

@section('title', 'Profil Admin')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            {{-- Ini Alert Sukses --}}
            @if (session('success'))
                <div id="success" class="alert alert-solid-success d-flex align-items-center" role="alert">
                    <span class="alert-icon rounded"><i class="ti ti-check"></i></span>
                    {{ session('success') }}
                </div>
            @endif

            {{-- Ini Alert Error --}}
            @if ($errors->any())
                <div class="alert alert-danger shadow-sm rounded-3 mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Ini Untuk Card Profile Dan Ganti Password --}}
            <div class="row g-4 align-items-stretch">

                <!-- Ini Untuk Card Profile Nya -->
                <div class="col-md-6">
                    <div class="card shadow-lg border-0 rounded-4 h-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-600 to-sky-500 text-white p-3 rounded-top-4 d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 fw-bold"><i class="ti ti-user me-1"></i> Data Profil</h4>
                        </div>
                        <div class="card-body text-center p-4">
                            <div class="position-relative d-inline-block mb-4">
                                <img src="{{ $user->profile_photo ? asset('uploads/profile/' . $user->profile_photo) : asset('/img/avatars/1.png') }}"
                                     alt="Foto Profil"
                                     class="rounded-circle shadow-lg border-4 border-white"
                                     style="width: 140px; height: 140px; object-fit: cover; transition: transform 0.3s;">
                                <label for="profile_photo" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2 shadow cursor-pointer" style="cursor: pointer;">
                                    <i class="ti ti-camera"></i>
                                </label>
                            </div>

                            <form action="{{ route('admin.profile.photo') }}" method="POST" enctype="multipart/form-data" class="mt-2">
                                @csrf
                                <input type="file" name="profile_photo" id="profile_photo" class="d-none" accept="image/*" onchange="this.form.submit()">
                            </form>

                            <table class="table table-borderless mt-3 text-start">
                                <tr>
                                    <th width="40%" class="text-muted">Nama</th>
                                    <td class="fw-semibold">{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Email</th>
                                    <td class="fw-semibold">{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Role</th>
                                    <td class="fw-semibold text-capitalize">{{ $user->role }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Ini Untuk Card Ganti Password Nya -->
                <div class="col-md-6">
                    <div class="card shadow-lg border-0 rounded-4 h-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-yellow-400 to-amber-500 text-dark p-3 rounded-top-4">
                            <h4 class="mb-0 fw-bold"><i class="ti ti-lock me-1"></i> Ganti Password</h4>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('admin.profile.password') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="current_password" class="form-label fw-semibold">Password Lama</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                                </div>
                                <div class="mb-3">
                                    <label for="new_password" class="form-label fw-semibold">Password Baru</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                                </div>
                                <div class="mb-4">
                                    <label for="new_password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-warning text-dark fw-bold px-4 shadow-sm">
                                        <i class="ti ti-refresh me-1"></i> Ganti Password
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
    // Ini untuk auto hide yang untuk alert success
    setTimeout(() => {
        const alert = document.getElementById('success');
        if (alert) {
            alert.style.transition = "opacity 0.5s ease";
            alert.style.opacity = 0;
            setTimeout(() => alert.remove(), 500);
        }
    }, 3000);

    // Ini Untuk Efek Hovernya
    const profileImg = document.querySelector('img[alt="Foto Profil"]');
    if (profileImg) {
        profileImg.addEventListener('mouseenter', () => profileImg.style.transform = 'scale(1.05)');
        profileImg.addEventListener('mouseleave', () => profileImg.style.transform = 'scale(1)');
    }
</script>
@endpush
