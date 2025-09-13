@extends('layouts.app')

@section('title', 'Detail Pengumuman')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="page-title">Detail Pengumuman</h3>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 200px">ID</th>
                        <td>{{ $pengumuman->id }}</td>
                    </tr>
                    <tr>
                        <th>Judul</th>
                        <td>{{ $pengumuman->judul }}</td>
                    </tr>
                    <tr>
                        <th>Isi</th>
                        <td>{!! nl2br(e($pengumuman->isi)) !!}</td>
                    </tr>
                    <tr>
                        <th>Dibuat Oleh</th>
                        <td>{{ $pengumuman->user->name ?? 'Guru' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>{{ $pengumuman->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                </table>

                <div class="mt-3 d-flex justify-content-betwen">
                    <a href="{{ route('guru.pengumuman.index') }}" class="btn btn-primary">
                        <span class="ti ti-arrow-left me-1"></span> 
                        Kembali
                    </a>
                    <a href="{{ route('guru.pengumuman.edit', $pengumuman->id) }}" class="btn btn-warning">
                        <span class="ti ti-pencil me-1"></span> 
                        Edit
                    </a>
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection