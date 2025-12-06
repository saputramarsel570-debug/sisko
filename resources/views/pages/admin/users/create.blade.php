@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-primary text-white rounded-top-4">
                <h4 class="mb-0 fw-bold"><i class="ti ti-user-plus"></i> Tambah User</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text"
                               class="form-control @error('username') is-invalid @enderror"
                               id="username" name="username"
                               value="{{ old('username') }}" required>
                        @error('username')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name"
                               value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email"
                               value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <input type="text" class="form-control" value="Admin" disabled>
                        @error('role')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                    
                        <div class="input-group">
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required>
                    
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                                <i class="ti ti-eye" id="iconPassword"></i>
                            </button>
                        </div>
                    
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>

                        <div class="input-group">
                            <input type="password"
                                class="form-control"
                                id="password_confirmation" name="password_confirmation">

                            <button type="button" class="btn btn-outline-secondary" onclick="toggleConfirm()">
                                <i class="ti ti-eye" id="iconConfirm"></i>
                            </button>
                        </div>
                    </div>

                    <script>
                        function togglePassword() {
                            const pass = document.getElementById('password');
                            const icon = document.getElementById('iconPassword');
                        
                            if (pass.type === "password") {
                                pass.type = "text";
                                icon.classList.replace("ti-eye", "ti-eye-off");
                            } else {
                                pass.type = "password";
                                icon.classList.replace("ti-eye-off", "ti-eye");
                            }
                        }
                        
                        function toggleConfirm() {
                            const pass = document.getElementById('password_confirmation');
                            const icon = document.getElementById('iconConfirm');
                        
                            if (pass.type === "password") {
                                pass.type = "text";
                                icon.classList.replace("ti-eye", "ti-eye-off");
                            } else {
                                pass.type = "password";
                                icon.classList.replace("ti-eye-off", "ti-eye");
                            }
                        }
                    </script>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-2">
                            <i class="ti ti-arrow-left"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-send"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
