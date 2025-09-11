@extends('layouts.app')

@section('title', 'Halaman Keluhan & Saran')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h3 class="page-title">Keluhan & Saran</h3>

        <div class="card card-body mb-4">
            <h5 class="mb-3">Form Keluhan dan Saran</h5>
            <form action="{{ route('orangtua.keluhan.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="text" name="judul" class="form-control" placeholder="Judul" required>
                </div>
                <div class="mb-3">
                    <textarea name="isi" rows="4" class="form-control" placeholder="Isi" required></textarea>
                </div>
                <button type="submit" class="btn btn-dark">KIRIM</button>
            </form>
        </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endpush

@push('scripts')
    <script src="{{ asset('/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script type='text/javascript'>
        $(function() {
            $('.dataTable').DataTable();
        });

        function actionDelete(url) {
            Swal.fire({
                title : "Apakah kamu yakin?",
                text : "Data yang dihapus tidak dapat dikembalikan!",
                icon : "warning",
                showCancelButton : true,
                confirmButtonText : "Ya, hapus saja!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#form-delete').attr('action', url);
                    $('#form-delete').submit();
                }
            });
        }
    </script>
@endpush