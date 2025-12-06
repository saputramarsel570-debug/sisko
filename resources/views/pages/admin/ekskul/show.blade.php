@extends('layouts.app')

@section('title', 'Detail Ekstrakurikuler')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-lg border-0 rounded-4">
            
            {{-- Header --}}
            <div class="card-header bg-info text-white rounded-top-4">
                <h4 class="mb-0 fw-bold"><i class="ti ti-trophy"></i> Detail Ekstrakurikuler</h4>
            </div>

            {{-- Body --}}
            <div class="card-body">
                <table class="table table-bordered mb-0 align-middle">
                    <tr>
                        <th width="30%">ID</th>
                        <td>{{ $ekskul->id }}</td>
                    </tr>
                    <tr>
                        <th>Nama Ekstrakurikuler</th>
                        <td>{{ $ekskul->nama }}</td>
                    </tr>
                    <tr>
                        <th>Nama Pembina</th>
                        <td>{{ $ekskul->nama_pembina ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $ekskul->deskripsi ?? '-' }}</td>
                    </tr>

                    {{-- Foto --}}
                    <tr>
                        <th>Foto</th>
                        <td class="text-center">
                            @if($ekskul->foto)
                                <img src="{{ asset('storage/' . $ekskul->foto) }}"
                                     alt="Foto {{ $ekskul->nama }}"
                                     class="img-thumbnail rounded-4 shadow-sm hover-zoom"
                                     style="max-height: 250px; object-fit: cover; cursor: pointer;"
                                     data-bs-toggle="modal" data-bs-target="#fotoModal">
                            @else
                                <span class="text-muted">Tidak ada foto</span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Dibuat Pada</th>
                        <td>{{ $ekskul->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Diperbarui Pada</th>
                        <td>{{ $ekskul->updated_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}</td>
                    </tr>
                </table>
            </div>

            {{-- Footer --}}
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('admin.ekskul.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('admin.ekskul.edit', $ekskul->id) }}" class="btn btn-warning text-white">
                    <i class="ti ti-pencil"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Modal Foto --}}
@if($ekskul->foto)
<div class="modal fade" id="fotoModal" tabindex="-1" aria-labelledby="fotoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content bg-transparent border-0 text-center">
      <img src="{{ asset('storage/' . $ekskul->foto) }}"
           alt="Foto {{ $ekskul->nama }}"
           class="img-fluid rounded-4 shadow-lg"
           style="max-height: 85vh; object-fit: contain;">
    </div>
  </div>
</div>
@endif
@endsection

@push('styles')
<style>
  .hover-zoom {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .hover-zoom:hover {
    transform: scale(1.03);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
  }

  .modal-backdrop.show {
    opacity: 0.85 !important;
  }

  .btn-close-white {
    filter: invert(1);
  }
</style>
@endpush