@extends('layouts.app')

@section('title', 'Keluhan & Saran Siswa')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="page-title">Keluhan & Saran Siswa</h3>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Kategori</th>
                                <th>Isi</th>
                                <th>Status</th>
                                <th>Balasan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($keluhan as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->user->name ?? '-' }}</td>
                                    <td>{{ ucfirst($item->kategori) }}</td>
                                    <td>{{ Str::limit($item->isi, 50) }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($item->status == 'pending') bg-warning 
                                            @elseif($item->status == 'proses') bg-primary 
                                            @elseif($item->status == 'selesai') bg-success 
                                            @else bg-secondary @endif">
                                            {{ ucfirst($item->status ?? 'pending') }}
                                        </span>
                                    </td>
                                    <td>{{ $item->balasan ?? '-' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <div class="gap-2 d-flex justify-content-betwen">
                                        <a href="{{ route('guru.keluhan.show', $item->id) }}" 
                                           class="btn btn-info btn-sm">Lihat</a>
                                        <a href="{{ route('guru.keluhan.edit', $item->id) }}" 
                                           class="btn btn-warning btn-sm">Edit</a>
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Belum ada keluhan atau saran</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection