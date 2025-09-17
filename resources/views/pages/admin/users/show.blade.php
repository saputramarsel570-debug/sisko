@extends('layouts.app')

@section('title', 'Detail User')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3 class="page-title">Detail User</h3>

                <div class="card card-body p-0">
                    <table class="table table-striped">
                        <tr>
                            <th width="25%">ID</th>
                            <th width="10px">:</th>
                            <td>{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <th width="25%">Username</th>
                            <th width="10px">:</th>
                            <td>{{ $user->username }}</td>
                        </tr>
                        <tr>
                            <th width="25%">Name</th>
                            <th width="10px">:</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th width="25%">Email</th>
                            <th width="10px">:</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th width="25%">Role</th>
                            <th width="10px">:</th>
                            <td>{{ $user->role }}</td>
                        </tr>
                        <tr>
                            <th width="25%">Terdaftar Pada</th>
                            <th width="10px">:</th>
                            <td>{{ $user->created_at->isoFormat('DD MMM Y HH:mm') }}</td>
                        </tr>
                        <tr>
                            <th width="25%">Diperbarui Pada</th>
                            <th width="10px">:</th>
                            <td>{{ $user->updated_at->isoFormat('DD MMM Y HH:mm') }}</td>
                        </tr>
                    </table>
                </div>

                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <span class="ti ti-arrow-left me-1"></span>
                        Kembali
                    </a>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
                        <span class="ti ti-pencil me-1"></span>
                        Edit
                    </a>
                </div>
        </div>
    </div>
@endsection
