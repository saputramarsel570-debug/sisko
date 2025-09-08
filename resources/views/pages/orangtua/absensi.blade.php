@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height:70vh;">
    <div class="card shadow p-4 text-center" style="max-width: 600px; width: 100%;">
        <h4 class="fw-bold mb-3">Dashboard {{ Auth::user()->role }}</h4>
        <p class="mb-0">Selamat Mantap, {{  Auth::user()->name }} </p>
    </div>
</div>
@endsection
