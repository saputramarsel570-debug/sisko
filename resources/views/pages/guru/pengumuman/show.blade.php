@extends('layouts.app-guru')

@section('title', 'Detail Pengumuman')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-primary text-white rounded-top-4 d-flex align-items-center">
                <h4 class="mb-0"><i class="ti ti-bell me-2"></i> Detail Pengumuman</h4>
            </div>

            <div class="card-body bg-light rounded-bottom-4">
                <div class="mb-3">
                    <h6 class="text-primary fw-semibold mb-1">Judul</h6>
                    <div class="p-3 bg-white rounded shadow-sm border">
                        {{ $pengumuman->judul }}
                    </div>
                </div>

                <div class="mb-3">
                    <h6 class="text-primary fw-semibold mb-1">Isi</h6>
                    <div class="p-3 bg-white rounded shadow-sm border" style="min-height: 100px;">
                        {!! nl2br(e($pengumuman->isi)) !!}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <h6 class="text-primary fw-semibold mb-1">Dibuat Oleh</h6>
                        <div class="p-3 bg-white rounded shadow-sm border">
                            {{ $pengumuman->user->name ?? 'Guru' }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary fw-semibold mb-1">Tanggal</h6>
                        <div class="p-3 bg-white rounded shadow-sm border">
                            {{ $pengumuman->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="text-primary fw-semibold mb-1">Tanggal Berakhir</h6>
                    <div class="p-3 bg-white rounded shadow-sm border">
                        @if ($pengumuman->tanggal_berakhir)
                            {{ \Carbon\Carbon::parse($pengumuman->tanggal_berakhir)->translatedFormat('d F Y') }}
                        @else
                            <span class="text-muted">Tidak ada batas waktu</span>
                        @endif
                    </div>
                </div>
                {{-- 📸 Gambar (klik untuk lihat besar) --}}
                @if ($pengumuman->gambar)
                <div class="mb-3 text-center mt-3">
                    <img src="{{ asset('storage/'.$pengumuman->gambar) }}" 
                         alt="gambar pengumuman" 
                         class="img-fluid rounded shadow-sm" 
                         style="max-height: 300px; cursor: pointer; object-fit: cover;"
                         onclick="showImageModal(this)">
                </div>
                @endif

                <div class="text-end mt-4">
                    <a href="{{ route('guru.pengumuman.index') }}" class="btn btn-primary px-4 rounded-3 shadow-sm">
                        <i class="ti ti-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 🖼 Modal Gambar Besar --}}
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 90%; max-height: 90%;">
        <div class="modal-content bg-transparent border-0 shadow-none" onclick="hideImageModal()">
            <img id="modalImage" src="" alt="Gambar besar" class="mx-auto d-block rounded-3" 
                 style="max-width: 100%; max-height: 90vh; object-fit: contain;">
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showImageModal(img) {
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    document.getElementById('modalImage').src = img.src;
    modal.show();
}
function hideImageModal() {
    const modalEl = document.getElementById('imageModal');
    const modal = bootstrap.Modal.getInstance(modalEl);
    modal.hide();
}
</script>
@endpush