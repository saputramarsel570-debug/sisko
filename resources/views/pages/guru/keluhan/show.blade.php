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
                        <td>{{ $keluhan->id }}</td>
                    </tr>
                    <tr>
                        <th>User</th>
                        <td>{{ $keluhan->user_id }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{!! nl2br(e($keluhan->kategori)) !!}</td>
                    </tr>
                    <tr>
                        <th>Isi</th>
                        <td>{{ $keluhan->isi ?? 'Guru' }}</td>
                    </tr>
                </table>

                <div class="mt-3 d-flex justify-content-betwen">
                    <a href="{{ route('guru.keluhan.index') }}" class="btn btn-primary">
                        <span class="ti ti-arrow-left me-1"></span> 
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection