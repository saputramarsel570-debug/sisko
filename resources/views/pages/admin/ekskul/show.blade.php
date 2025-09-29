@extends('layouts.app')

@section('title', 'Detail Ekstrakurikuler')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-info text-white rounded-top-4">
                <h4 class="mb-0 fw-bold"><i class="ti ti-trophy"></i> Detail Ekstrakurikuler</h4>
            </div>

            <div class="card-body">
                <table class="table table-bordered mb-0">
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
                    <tr>
                        <th>Foto</th>
                        <td>
                            @if($ekskul->foto)
                                <img src="{{ asset('storage/' . $ekskul->foto) }}"
                                     alt="Foto {{ $ekskul->nama }}"
                                     class="img-thumbnail rounded" width="250">
                            @else
                                <span class="text-muted">Tidak ada foto</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Dibuat Pada</th>
                        <td>{{ $ekskul->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Diperbarui Pada</th>
                        <td>{{ $ekskul->updated_at->format('d M Y H:i') }}</td>
                    </tr>
                </table>
            </div>

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
@endsection
