@extends('layouts.app')

@section('title', 'Detail Guru')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h3 class="page-title mb-3">Detail Guru</h3>

        <div class="card">
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th>ID</th>
                        <td>{{ $guru->id }}</td>
                    </tr>
                    <tr>
                        <th>User_ID</th>
                        <td>{{ $guru->user_id }}</td>
                    </tr>
                    <tr>
                        <th>NIP</th>
                        <td>{{ $guru->nip ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th style="width: 200px;">Nama</th>
                        <td>{{ $guru->nama }}</td>
                    </tr>
                    <tr>
                        <th>Mapel</th>
                        <td>{{ $guru->mapel }}</td>
                    </tr>
                    <tr>
                        <th>Dibuat pada</th>
                        <td>{{ $guru->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Terakhir diperbarui</th>
                        <td>{{ $guru->updated_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td>{{ $guru->user->username }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $guru->user->email }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary">
                <i class="ti ti-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('admin.guru.edit', $guru->id) }}" class="btn btn-warning">
                <i class="ti ti-pencil"></i> Edit
            </a>
        </div>
    </div>
</div>
@endsection
