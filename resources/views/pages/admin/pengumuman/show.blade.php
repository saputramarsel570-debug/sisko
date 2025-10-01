@extends('layouts.app')

@section('title', 'Detail Pengumuman')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-info text-white rounded-top-4">
                <h4 class="mb-0 fw-bold"><i class="ti ti-bell"></i> Detail Pengumuman</h4>
            </div>

            <div class="card-body">
                <table class="table table-bordered mb-0">
                    <tr>
                        <th width="30%">ID</th>
                        <td>{{ $pengumuman->id }}</td>
                    </tr>
                    <tr>
                        <th>Judul</th>
                        <td>{{ $pengumuman->judul }}</td>
                    </tr>
                    <tr>
                        <th>Isi</th>
                        <td>{!! nl2br(e($pengumuman->isi)) !!}</td>
                    </tr>
                    <tr>
                        <th>Target Audiens</th>
                        <td class="text-capitalize">{{ $pengumuman->target }}</td>
                    </tr>
                    <tr>
                        <th>Dibuat Oleh</th>
                        <td>{{ $pengumuman->user->name ?? 'Guru' }}</td>
                    </tr>
                    <tr>
                        <th>Dibuat Pada</th>
                        <td>{{ $pengumuman->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Diperbarui Pada</th>
                        <td>{{ $pengumuman->updated_at->format('d M Y H:i') }}</td>
                    </tr>
                </table>
            </div>

            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('admin.pengumuman.edit', $pengumuman->id) }}" class="btn btn-warning text-white">
                    <i class="ti ti-pencil"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
