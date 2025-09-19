@extends('layouts.app')

@section('title', 'Pengaturan Sekolah')

@section('content')
<div class="row">
    <div class="col-md-10 offset-md-1">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="ti ti-check me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="ti ti-settings me-2"></i> Pengaturan Sekolah
                </h5>
                <a href="{{ route('admin.pengaturan.edit', $pengaturan->id) }}" class="btn btn-warning btn-sm">
                    <i class="ti ti-edit"></i> Edit
                </a>
            </div>

            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-3 text-center">
                        @if($pengaturan->logo)
                            <img src="{{ asset('storage/'.$pengaturan->logo) }}" class="rounded mb-2" height="100" alt="Logo Sekolah">
                        @else
                            <div class="bg-light text-muted d-flex align-items-center justify-content-center rounded mb-2" style="width:100px; height:100px;">
                                <i class="ti ti-building"></i>
                            </div>
                        @endif
                        <small class="text-muted d-block">Logo Sekolah</small>
                    </div>
                    <div class="col-md-9">
                        <h4 class="mb-1">{{ $pengaturan->nama_sekolah }}</h4>
                        <p class="mb-0 text-muted">NPSN: {{ $pengaturan->npsn }}</p>
                        <p class="mb-0 text-muted">Jenjang: {{ $pengaturan->jenjang }}</p>
                    </div>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <th style="width: 30%">Alamat</th>
                        <td>{{ $pengaturan->alamat }}</td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td>{{ $pengaturan->telepon ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $pengaturan->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kepala Sekolah</th>
                        <td>{{ $pengaturan->kepala_sekolah ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>NIP Kepala Sekolah</th>
                        <td>{{ $pengaturan->nip_kepala_sekolah ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tahun Ajaran</th>
                        <td>{{ $pengaturan->tahun_ajaran }}</td>
                    </tr>
                    <tr>
                        <th>Semester</th>
                        <td>{{ ucfirst($pengaturan->semester) }}</td>
                    </tr>
                    <tr>
                        <th>Kop Surat</th>
                        <td>
                            @if($pengaturan->kop_surat)
                                <img src="{{ asset('storage/'.$pengaturan->kop_surat) }}" class="img-fluid rounded border" alt="Kop Surat">
                            @else
                                <span class="text-muted">Belum diunggah</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Tanda Tangan Kepala Sekolah</th>
                        <td>
                            @if($pengaturan->ttd_kepsek)
                                <img src="{{ asset('storage/'.$pengaturan->ttd_kepsek) }}" height="80" class="rounded border" alt="TTD Kepala Sekolah">
                            @else
                                <span class="text-muted">Belum diunggah</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
