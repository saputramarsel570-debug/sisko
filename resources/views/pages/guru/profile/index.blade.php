@extends('layouts.app')

@section('title', 'Profil Guru')

@section('content')
    <div class="container">
        <h3 class="mb-4 text-center">Profil Guru</h3>

        @if (session('success'))
            <div id="success" class="alert alert-solid-success d-flex align-items-center" role="alert">
                <span class="alert-icon rounded"><i class="ti ti-check"></i></span>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="mb-3">Data Identitas</h5>

                        <div class="mb-3">
                            <img src="{{ $user->profile_photo ? asset('uploads/profile/' . $user->profile_photo) : 'https://via.placeholder.com/120' }}" alt="Foto Profil" class="rounded-circle mb-2" style="width: 120px; height: 120px; object-fit: cover;" />

                            <form action="{{ route('guru.profile.photo') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group mt-2">
                                    <input type="file" name="profile_photo" id="profile_photo" class="form-control form-control-sm" accept="image/*" required>
                                    <button type="submit" class="btn btn-sm btn-primary">Ganti Foto</button>
                                </div>
                            </form>
                        </div>

                        <p><strong>Nama :</strong>{{ $user->name }}</p>
                        <p><strong>Email :</strong>{{ $user->email }}</p>
                        <p><strong>Role :</strong>{{ ucfirst($user->role) }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="mb-3">Ganti Password</h5>

                        <form action="{{ route('guru.profile.password') }}" method="POST">
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
                            <button type="submit" class="btn btn-primary">Ganti Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
