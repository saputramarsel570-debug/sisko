@extends('layouts.app-siswa_perwakilan')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="container mt-4">
    <h3 class="fw-bold mb-4">Dashboard Siswa</h3>

    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-gradient bg-primary text-white">
            <h5 class="mb-0">Detail Siswa</h5>
        </div>
        <div class="card-body p-4">
            <table class="table table-hover align-middle">
                <tbody>
                    <tr>
                        <th width="200">NIS</th>
                        <td>{{ $siswa->nis }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $siswa->nama }}</td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td>
                            <span class="badge bg-success">
                                {{ $siswa->kelas->nama_kelas ?? '-' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $siswa->alamat }}</td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td>{{ $user->username }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>
                            <span class="badge bg-info text-dark">
                                {{ ucfirst($user->role) }}
                            </span>
                            <br>
                            <small class="text-muted">
                                @if($user->role == 'siswa')
                                @elseif($user->role == 'guru')
                                @elseif($user->role == 'orang_tua')
                                @endif
                            </small>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection