@extends('layouts.app')

@section('content')
    <h4 class="fw-bold">Dashboard Admin</h4>
    <p>Selamat Datang, {{ Auth::user()->name }} ({{ Auth::user()->role }})</p>
@endsection
