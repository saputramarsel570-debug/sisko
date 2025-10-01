@extends('layouts.app')

@section('title', 'Detail Keluhan & Saran')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-info text-white rounded-top-4">
                <h4 class="mb-0 fw-bold"><i class="ti ti-message-circle"></i> Detail Keluhan & Saran</h4>
            </div>

            <div class="card-body">
                <table class="table table-bordered mb-0">
                    <tr>
                        <th width="30%">ID</th>
                        <td>{{ $keluhanSaran->id }}</td>
                    </tr>
                    <tr>
                        <th>Pengirim</th>
                        <td>{{ $keluhanSaran->user->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>
                            <span class="badge bg-{{ $keluhanSaran->kategori == 'keluhan' ? 'danger' : 'info' }}">
                                {{ ucfirst($keluhanSaran->kategori) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Isi</th>
                        <td>{{ $keluhanSaran->isi }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($keluhanSaran->status == 'pending')
                                <span class="badge bg-secondary">Pending</span>
                            @elseif($keluhanSaran->status == 'proses')
                                <span class="badge bg-warning text-dark">Proses</span>
                            @else
                                <span class="badge bg-success">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Dikirim Pada</th>
                        <td>{{ $keluhanSaran->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Diperbarui Pada</th>
                        <td>{{ $keluhanSaran->updated_at->format('d M Y H:i') }}</td>
                    </tr>
                </table>
            </div>

            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('admin.keluhan_saran.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('admin.keluhan_saran.edit', $keluhanSaran->id) }}" class="btn btn-warning text-white">
                    <i class="ti ti-pencil"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
