@extends('layouts.app-guru')

@section('title', 'Profil Guru')

@section('content')
<div class="container">
    <h3 class="mb-4 text-center">Profil Guru</h3>

    {{-- Notifikasi --}}
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

    <div class="row justify-content-center g-4">
        {{-- Data Identitas --}}
        <div class="col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="mb-3 fw-semibold"><i class="ti ti-user"></i> Data Identitas</h5>

                    <div class="text-center mb-3">
                        <img 
                            src="{{ $user->profile_photo ? asset('uploads/profile/' . $user->profile_photo) : 'https://via.placeholder.com/120' }}" 
                            alt="Foto Profil" 
                            class="rounded-circle border mb-2" 
                            style="width: 120px; height: 120px; object-fit: cover; cursor: pointer;"
                            onclick="showImageModal(this.src)"
                        />

                        <form action="{{ route('guru.profile.photo') }}" method="POST" enctype="multipart/form-data" class="d-flex justify-content-center mt-2">
                            @csrf
                            <input type="file" name="profile_photo" id="profile_photo" class="form-control form-control-sm w-75" accept="image/*" required>
                            <button type="submit" class="btn btn-sm btn-primary ms-2">Ganti</button>
                        </form>
                    </div>

                    <p><strong>Nama :</strong> {{ $user->name }}</p>
                    <p><strong>Email :</strong> {{ $user->email }}</p>
                    <p><strong>Role :</strong> {{ ucfirst($user->role) }}</p>
                </div>
            </div>
        </div>

        {{-- Form Ganti Password & Email --}}
        <div class="col-md-5">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="mb-3 fw-semibold"><i class="ti ti-mail"></i> Ganti Email</h5>
                    <form action="{{ route('guru.profile.email') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Baru</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Perbarui Email</button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="mb-3 fw-semibold"><i class="ti ti-lock"></i> Ganti Password</h5>

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
                        <button type="submit" class="btn btn-primary w-100">Ganti Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Preview Foto --}}
<div class="modal fade" id="photoModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-transparent border-0 text-center">
      <img id="photoPreview" src="" class="rounded shadow-lg" style="max-width: 100%; height: auto;">
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto-hide alert sukses
    setTimeout(() => {
        let alert = document.getElementById('success');
        if (alert) {
            alert.style.transition = "opacity 0.5s ease";
            alert.style.opacity = 0;
            setTimeout(() => alert.remove(), 500);
        }
    }, 3000);

    // Modal preview foto
    function showImageModal(src) {
        const modal = new bootstrap.Modal(document.getElementById('photoModal'));
        document.getElementById('photoPreview').src = src;
        modal.show();
    }
</script>
@endpush