@extends('layouts.app')

@section('title', 'Edit Data Orang Tua')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-warning text-dark rounded-top-4">
                <h4 class="mb-0 fw-bold"><i class="ti ti-user-edit"></i> Edit Data Orang Tua</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.orangtua.update', $orangtua->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Orang Tua</label>
                        <input type="text" name="nama" id="nama"
                               class="form-control @error('nama') is-invalid @enderror"
                               value="{{ old('nama', $orangtua->nama) }}" required>
                        @error('nama') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="no_hp" class="form-label">No HP</label>
                        <input type="text" name="no_hp" id="no_hp"
                               class="form-control @error('no_hp') is-invalid @enderror"
                               value="{{ old('no_hp', $orangtua->no_hp) }}" required>
                        @error('no_hp') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="siswa_id" class="form-label">Pilih Siswa</label>
                        <select name="siswa_id" id="siswa_id"
                                class="form-select @error('siswa_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Siswa --</option>
                            @foreach ($siswa as $s)
                                <option value="{{ $s->id }}"
                                    {{ old('siswa_id', $orangtua->siswa_id) == $s->id ? 'selected' : '' }}>
                                    {{ $s->nama }} ({{ $s->kelas->nama_kelas ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                        @error('siswa_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <hr>
                    <h5 class="fw-bold">Data Login</h5>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username"
                               class="form-control @error('username') is-invalid @enderror"
                               value="{{ old('username', $orangtua->user->username) }}" required>
                        @error('username') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $orangtua->user->email) }}" required>
                        @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru (opsional)</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password"
                                   class="form-control @error('password') is-invalid @enderror">
                            <span class="input-group-text" onclick="togglePassword('password', 'iconPassword')">
                                <i id="iconPassword" class="ti ti-eye"></i>
                            </span>
                        </div>
                        @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <div class="input-group">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                            <span class="input-group-text" onclick="togglePassword('password_confirmation', 'iconConfirm')">
                                <i id="iconConfirm" class="ti ti-eye"></i>
                            </span>
                        </div>
                    </div>

                    @push('scripts')
                        <script>
                        function togglePassword(inputId, iconId) {
                            const input = document.getElementById(inputId);
                            const icon = document.getElementById(iconId);

                            if (input.type === "password") {
                                input.type = "text";
                                icon.classList.replace("ti-eye", "ti-eye-off");
                            } else {
                                input.type = "password";
                                icon.classList.replace("ti-eye-off", "ti-eye");
                            }
                        }
                        </script>
                    @endpush

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.orangtua.index') }}" class="btn btn-secondary">
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
