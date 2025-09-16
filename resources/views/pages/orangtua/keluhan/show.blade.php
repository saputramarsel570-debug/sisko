@extends('layouts.app')

@section('title', 'Detail Keluhan & Saran')

@section('content')
    <div class="row">
        <div class="col-md-12 offset-md-12">
            <h3 class="page-title">Detail Keluhan & Saran</h3>

            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <td>{{ $keluhan->id }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>{{ $keluhan->kategori }}</td>
                        </tr>
                        <tr>
                            <th>Isi</th>
                            <td>{{ $keluhan->isi }}</td>
                        </tr>
                        <tr>
                            <th>Pengirim</th>
                            <td>{{ ucfirst($keluhan->tipe_pengirim) }}</td>
                        </tr>
                        <tr>
                            <th>Dibuat Oleh</th>
                            <td>{{ $keluhan->user->name ?? 'Orangtua' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>{{ $keluhan->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                    </table>

                    <div class="btn-group mt-3">
                    <div class="gap-2 d-flex justify-content-betwen">
                        <a href="{{ route('orangtua.keluhan.index') }}" class="btn btn-primary">
                            <span class="ti ti-arrow-left me-1"></span> 
                            Kembali
                        </a>
                        <a href="{{ route('orangtua.keluhan.edit', $keluhan->id) }}" class="btn btn-warning m">
                            <span class="ti ti-pencil me-1"></span> 
                            Edit
                        </a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection