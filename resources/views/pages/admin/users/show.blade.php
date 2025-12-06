@extends('layouts.app')

@section('title', 'Detail User')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-info text-white rounded-top-4">
                <h4 class="mb-0 fw-bold">
                    <i class="ti ti-user"></i> Detail User
                </h4>
            </div>

            <div class="card-body">
                <table class="table table-bordered mb-0">
                    <tr>
                        <th width="30%">ID</th>
                        <td>{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td>{{ $user->username }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>
                            <span class="badge bg-primary">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Terdaftar Pada</th>
                        <td>
                            {{ $user->created_at 
                                ? $user->created_at->copy()->timezone('Asia/Jakarta')->format('d M Y H:i') 
                                : '-' 
                            }}
                        </td>
                    </tr>
                    
                    <tr>
                        <th>Diperbarui Pada</th>
                        <td>
                            {{ $user->updated_at 
                                ? $user->updated_at->copy()->timezone('Asia/Jakarta')->format('d M Y H:i') 
                                : '-' 
                            }}
                        </td>
                    </tr>
                </table>
            </div>

            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">
                    <i class="ti ti-pencil"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
