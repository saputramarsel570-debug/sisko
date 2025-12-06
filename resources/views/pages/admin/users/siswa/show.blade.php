@extends('layouts.app')

@section('title', 'Detail Siswa')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-info text-white rounded-top-4">
                <h4 class="mb-0 fw-bold"><i class="ti ti-user"></i> Detail Siswa</h4>
            </div>

            <div class="card-body">
                <table class="table table-bordered mb-0">
                    <tr>
                        <th width="30%">ID</th>
                        <td>{{ $siswa->id }}</td>
                    </tr>
                    <tr>
                        <th>User ID</th>
                        <td>{{ $siswa->user_id }}</td>
                    </tr>
                    <tr>
                        <th>NIS</th>
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
                        <td>{{ $siswa->alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td>{{ $siswa->user->username }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $siswa->user->email }}</td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>
                            @if($siswa->user->role == 'siswa_perwakilan')
                                <span class="badge bg-success">Siswa Perwakilan</span>
                            @else
                                <span class="badge bg-secondary">Siswa</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Dibuat Pada</th>
                        <td>
                            {{ $siswa->created_at 
                                ? $siswa->created_at->copy()->timezone('Asia/Jakarta')->format('d M Y H:i') 
                                : '-' 
                            }}
                        </td>
                    </tr>
                    
                    <tr>
                        <th>Diperbarui Pada</th>
                        <td>
                            {{ $siswa->updated_at 
                                ? $siswa->updated_at->copy()->timezone('Asia/Jakarta')->format('d M Y H:i') 
                                : '-' 
                            }}
                        </td>
                    </tr>
                </table>
            </div>

            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="btn btn-warning text-white">
                    <i class="ti ti-pencil"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
