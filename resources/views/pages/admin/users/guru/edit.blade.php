@extends('layouts.app')

@section('title', 'Edit Data Guru')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-warning text-dark rounded-top-4">
                <h4 class="mb-0 fw-bold"><i class="ti ti-user-edit"></i> Edit Data Guru</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.guru.update', $guru->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" name="nip" id="nip"
                               class="form-control @error('nip') is-invalid @enderror"
                               value="{{ old('nip', $guru->nip) }}" required>
                        @error('nip') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Guru</label>
                        <input type="text" name="nama" id="nama"
                               class="form-control @error('nama') is-invalid @enderror"
                               value="{{ old('nama', $guru->nama) }}" required>
                        @error('nama') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="mata_pelajaran_id" class="form-label">Mata Pelajaran</label>
                        <select name="mata_pelajaran_id" id="mata_pelajaran_id"
                                class="form-select @error('mata_pelajaran_id') is-invalid @enderror">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($mataPelajaran as $mapel)
                                <option value="{{ $mapel->id }}"
                                    {{ old('mata_pelajaran_id', $guru->mata_pelajaran_id) == $mapel->id ? 'selected' : '' }}>
                                    {{ $mapel->nama_mapel }}
                                </option>
                            @endforeach
                        </select>
                        @error('mata_pelajaran_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <hr>
                    <h5 class="fw-bold">Data Login</h5>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username"
                               class="form-control @error('username') is-invalid @enderror"
                               value="{{ old('username', $guru->user->username) }}" required>
                        @error('username') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $guru->user->email) }}" required>
                        @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru (opsional)</label>
                    
                        <div class="input-group">
                            <input type="password" name="password" id="password"
                                   class="form-control @error('password') is-invalid @enderror">
                    
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                                <i class="ti ti-eye" id="iconPassword"></i>
                            </button>
                        </div>
                    
                        @error('password') 
                            <div class="invalid-feedback d-block">{{ $message }}</div> 
                        @enderror
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    
                        <div class="input-group">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="form-control">
                    
                            <button type="button" class="btn btn-outline-secondary" onclick="toggleConfirm()">
                                <i class="ti ti-eye" id="iconConfirm"></i>
                            </button>
                        </div>
                    </div>

                    @push('scripts')
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
                    @endpush

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary">
                            <i class="ti ti-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="ti ti-device-floppy"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
