@extends('layouts.app')

@section('title', 'Halaman Keluhan & Saran')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3 class="page-title">Keluhan & Saran</h3>
            
            <a href="{{ route('siswa.keluhan.create') }}" class="btn btn-primary mb-3">
                <span class="ti ti-plus me-1"></span>
                Tambah
            </a>
            
            <div class="card">
                <div class="card-bofy">
                    
                </div>
            </div>
        </div>
    </div>