@extends('layouts.app')

@section('title', 'Detail Orang Tua')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-info text-white rounded-top-4">
                <h4 class="mb-0 fw-bold"><i class="ti ti-user"></i> Detail Orang Tua</h4>
            </div>

            <div class="card-body">
                <table class="table table-bordered mb-0">
                    <tr>
                        <th width="30%">ID</th>
                        <td>{{ $orangtua->id }}</td>
                    </tr>
                    <tr>
                        <th>User ID</th>
                        <td>{{ $orangtua->user_id }}</td>
                    </tr>
                    <tr>
                        <th>Siswa ID</th>
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
                    <tr>
                        <th>Dibuat Pada</th>
                        <td>
                            {{ $orangtua->created_at 
                                ? $orangtua->created_at->copy()->timezone('Asia/Jakarta')->format('d M Y H:i') 
                                : '-' 
                            }}
                        </td>
                    </tr>
                    
                    <tr>
                        <th>Diperbarui Pada</th>
                        <td>
                            {{ $orangtua->updated_at 
                                ? $orangtua->updated_at->copy()->timezone('Asia/Jakarta')->format('d M Y H:i') 
                                : '-' 
                            }}
                        </td>
                    </tr>
                </table>
            </div>

            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('admin.orangtua.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('admin.orangtua.edit', $orangtua->id) }}" class="btn btn-warning text-white">
                    <i class="ti ti-pencil"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
