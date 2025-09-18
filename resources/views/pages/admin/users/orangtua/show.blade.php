@extends('layouts.app')

@section('title', 'Detail Orang Tua')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="page-title">Detail Orang Tua</h3>

        <div class="card card-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td>{{ $orangtua->id }}</td>
                </tr>
                <tr>
                    <th>User_ID</th>
                    <td>{{ $orangtua->user_id }}</td>
                </tr>
                <tr>
                    <th>Siswa_ID</th>
                    <td>{{ $orangtua->siswa_id }}</td>
                </tr>
                <tr>
                    <th>Nama Orang Tua</th>
                    <td>{{ $orangtua->nama }}</td>
                </tr>
                <tr>
                    <th>No HP</th>
                    <td>{{ $orangtua->no_hp }}</td>
                </tr>
                <tr>
                    <th>Nama Siswa</th>
                    <td>{{ $orangtua->siswa->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Kelas</th>
                    <td>{{ $orangtua->siswa->kelas->nama_kelas ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td>{{ $orangtua->user->username ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $orangtua->user->email ?? '-' }}</td>
                </tr>
            </table>

            <div class="flex">
                <a href="{{ route('admin.orangtua.index') }}" class="btn btn-secondary">
                    <span class="ti ti-arrow-left"></span> Kembali
                </a>
                <a href="{{ route('admin.orangtua.edit', $orangtua->id) }}" class="btn btn-warning">
                    <span class="ti ti-pencil"></span> Edit
                </a>
            </div>
        </div>
    </div>
</div>
@endsection