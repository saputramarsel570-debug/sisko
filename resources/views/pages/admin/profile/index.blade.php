@extends('layouts.app')

@section('title', 'Profil Admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-primary text-white rounded-top-4 text-center py-3">
                    <h4 class="mb-0"><i class="ti ti-user-circle"></i> Profil Admin</h4>
                </div>

                <div class="card-body p-4">

                    {{-- Notifikasi --}}
                    @if (session('success'))
                        <div id="success" class="alert alert-solid-success d-flex align-items-center" role="alert">
                            <span class="alert-icon rounded"><i class="ti ti-check"></i></span>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Foto Profil + Upload --}}
                    <div class="text-center mb-4">
                        <img 
                            src="{{ $user->profile_photo ? asset('uploads/profile/' . $user->profile_photo) : 'https://via.placeholder.com/150' }}" 
                            alt="Foto Profil" 
                            class="rounded-circle shadow-sm border"
                            style="width: 150px; height:150px; object-fit: cover; cursor: pointer;"
                            onclick="showImageModal(this.src)"
                        >

                        <form action="{{ route('admin.profile.photo') }}" method="POST" enctype="multipart/form-data" class="mt-3 d-flex justify-content-center">
                            @csrf
                            <input type="file" name="profile_photo" class="form-control form-control-sm w-50" accept="image/*" required>
                            <button type="submit" class="btn btn-sm btn-primary ms-2 px-3">
                                <i class="ti ti-upload"></i> Ganti
                            </button>
                        </form>
                    </div>

                    <hr>

                    {{-- Informasi Admin --}}
                    <div class="mt-4">
                        <h5 class="fw-semibold mb-3"><i class="ti ti-id-badge"></i> Informasi Akun</h5>

                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between">
                                <strong>Nama</strong>
                                <span>{{ $user->name }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between">
                                <strong>Email</strong>
                                <span>{{ $user->email }}</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between">
                                <strong>Role</strong>
                                <span class="badge bg-success px-3 py-2">{{ ucfirst($user->role) }}</span>
                            </div>
                        </div>
                    </div>

                </div> {{-- end card body --}}
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
    // Auto hide alert
    setTimeout(() => {
        let alert = document.getElementById('success');
        if (alert) {
            alert.style.transition = "opacity 0.6s ease";
            alert.style.opacity = 0;
            setTimeout(() => alert.remove(), 600);
        }
    }, 2500);

    // Show modal preview
    function showImageModal(src) {
        const modal = new bootstrap.Modal(document.getElementById('photoModal'));
        document.getElementById('photoPreview').src = src;
        modal.show();
    }
</script>
@endpush