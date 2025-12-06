@extends('layouts.app')

@section('title', 'Detail Jadwal Ekskul')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-lg border-0 rounded-4">
            
            {{-- Header --}}
            <div class="card-header bg-info text-white rounded-top-4">
                <h4 class="mb-0 fw-bold">
                    <i class="ti ti-calendar-event"></i> Detail Jadwal Ekskul
                </h4>
            </div>

            {{-- Body --}}
            <div class="card-body">
                <table class="table table-bordered mb-0">
                    <tr>
                        <th width="30%">ID</th>
                        <td>{{ $jadwal_ekskul->id }}</td>
                    </tr>
                    <tr>
                        <th>Nama Ekskul</th>
                        <td>{{ $jadwal_ekskul->ekstrakurikuler->nama }}</td>
                    </tr>
                    <tr>
                        <th>Pembina</th>
                        <td>{{ $jadwal_ekskul->ekstrakurikuler->nama_pembina ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Hari</th>
                        <td>
                            @php
                                $hariList = $jadwal_ekskul->hari;
                                if (!is_array($hariList)) {
                                    $hariList = json_decode($hariList, true) ?? [];
                                }
                            @endphp
                            @if(!empty($hariList))
                                {{ implode(', ', $hariList) }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $jadwal_ekskul->ekstrakurikuler->deskripsi ?? '-' }}</td>
                    </tr>

                    {{-- Foto --}}
                    @if(!empty($jadwal_ekskul->ekstrakurikuler->foto))
                    <tr>
                        <th>Foto</th>
                        <td class="text-center">
                            <img src="{{ asset('storage/' . $jadwal_ekskul->ekstrakurikuler->foto) }}"
                                 alt="Foto {{ $jadwal_ekskul->ekstrakurikuler->nama }}"
                                 class="img-thumbnail rounded-4 shadow-sm hover-zoom"
                                 style="max-height: 250px; cursor: pointer; object-fit: cover;"
                                 data-bs-toggle="modal"
                                 data-bs-target="#fotoModal">
                        </td>
                    </tr>
                    @endif

                    <tr>
                        <th>Dibuat Pada</th>
                        <td>{{ $jadwal_ekskul->created_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Diperbarui Pada</th>
                        <td>{{ $jadwal_ekskul->updated_at->timezone('Asia/Jakarta')->format('d-m-Y H:i') }}</td>
                    </tr>
                </table>
            </div>

            {{-- Footer --}}
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('admin.jadwal_ekskul.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('admin.jadwal_ekskul.edit', $jadwal_ekskul->id) }}" class="btn btn-warning text-white">
                    <i class="ti ti-pencil"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Modal Foto --}}
@if(!empty($jadwal_ekskul->ekstrakurikuler->foto))
<div class="modal fade" id="fotoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-transparent border-0 text-center">
            <img src="{{ asset('storage/' . $jadwal_ekskul->ekstrakurikuler->foto) }}"
                 alt="Foto {{ $jadwal_ekskul->ekstrakurikuler->nama }}"
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
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
  }

  .modal-backdrop.show {
    opacity: 0.85 !important;
  }
</style>
@endpush