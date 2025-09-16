@extends('layouts.app')

@section('title', 'Detail Keluhan & Saran')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h3 class="page-title">Detail Keluhan & Saran</h3>

            <div class="card card-body">
                <dl class="row">
                    <dt class="col-sm-4">Pengirim</dt>
                    <dd class="col-sm-8">{{ $keluhanSaran->user->name ?? '-' }}</dd>
                    <dt class="col-sm-4">Kategori</dt>
                    <dd class="col-sm-8"><span class="badge bg-{{ $keluhanSaran->kategori == 'keluhan' ? 'danger' : 'info' }}">{{ ucfirst($keluhanSaran->kategori) }}</span></dd>
                    <dt class="col-sm-4">Isi</dt>
                    <dd class="col-sm-8">{{ $keluhanSaran->isi }}</dd>
                    <dt class="col-sm-4">Status</dt>
                    <dd class="col-sm-8">
                        @if($keluhanSaran->status == 'pending')
                            <span class="badge bg-secondary">Pending</span>
                        @elseif($keluhanSaran->status == 'proses')
                            <span class="badge bg-warning text-dark">Proses</span>
                        @else
                            <span class="badge bg-success">Selesai</span>
                        @endif
                    </dd>
                    <dt class="col-sm-4">Dikirim</dt>
                    <dd class="col-sm-8">{{ $keluhanSaran->created_at->format('d M Y H:i') }}</dd>
                </dl>
            </div>
        </div>

        <div class="mt-3 d-flex justify-content-between">
            <a href="{{ route('admin.keluhan_saran.index') }}" class="btn btn-secondary">
                <i class="ti ti-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('admin.keluhan_saran.edit', $keluhanSaran->id) }}" class="btn btn-warning">
                <i class="ti ti-edit"></i> Edit
            </a>
        </div>
    </div>
@endsection
