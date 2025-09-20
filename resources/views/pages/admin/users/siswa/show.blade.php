@extends('layouts.app')

@section('title', 'Detail Siswa')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <h3 class="page-title mb-3">Detail Siswa</h3>

        <div class="card">
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th>ID</th>
                        <td>{{ $siswa->id }}</td>
                    </tr>
                    <tr>
                        <th>User_ID</th>
                        <td>{{ $siswa->user_id }}</td>
                    </tr>
                    <tr>
                        <th style="width: 200px;">NIS</th>
                        <td>{{ $siswa->nis }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $siswa->nama }}</td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td>{{ $siswa->kelas->nama_kelas }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $siswa->alamat }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $siswa->user->email }}</td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td>{{ $siswa->user->username }}</td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>{{ ucfirst(str_replace('_', ' ', $siswa->user->role)) }}</td>
                    </tr>
                    <tr>
                        <th>Dibuat pada</th>
                        <td>{{ $siswa->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Terakhir diperbarui</th>
                        <td>{{ $siswa->updated_at->format('d M Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">
                <i class="ti ti-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="btn btn-warning">
                <i class="ti ti-pencil"></i> Edit
            </a>
        </div>
    </div>
</div>
@endsection
