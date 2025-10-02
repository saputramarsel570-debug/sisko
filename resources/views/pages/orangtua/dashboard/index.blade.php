@extends('layouts.app')

@section('title', 'Dashboard Orang Tua')

@section('content')
<div class="container mt-4">
    <h3 class="fw-bold mb-4">👋 Dashboard Orangtua</h3>

    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-gradient bg-primary text-white">
            <h5 class="mb-0">Detail Orangtua</h5>
        </div>
        <div class="card-body p-4">
            <table class="table table-hover align-middle">
                <tbody>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $orangtua->nama }}</td>
                    </tr>
                    <tr>
                        <th>No Telepon</th>
                        <td>{{ $orangtua->no_hp }}</td>
                    </tr>
                    <tr>
                        <th>Nama Siswa</th>
                        <td>{{ $orangtua->siswa->nama }}</td>
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