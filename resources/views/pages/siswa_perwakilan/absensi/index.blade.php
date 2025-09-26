@extends('layouts.app')

@section('title', 'Absensi Kelas')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        @if (session('success'))
                <div id="success" class="alert alert-solid-success d-flex align-items-center" role="alert">
                    <span class="alert-icon rounded"><i class="ti ti-check"></i></span>
                    {{ session('success') }}
                </div>
            @endif
        <h4 class="mb-0">Isi Absensi</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('siswa_perwakilan.absensi.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Kelas</label>
                <input type="text" class="form-control" value="{{ $kelas->nama_kelas }}" disabled>
            </div>

            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th width="150">Status</th>
                        <th width="250">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswaKelas as $siswa)
                        <tr>
                            <td>{{ $siswa->nama }}</td>
                            <td>
                                <select name="absensi[{{ $siswa->id }}][status]" class="form-select" required>
                                    <option value="hadir">Hadir</option>
                                    <option value="izin">Izin</option>
                                    <option value="sakit">Sakit</option>
                                    <option value="alfa">Alfa</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="absensi[{{ $siswa->id }}][keterangan]" class="form-control" placeholder="Opsional">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">SIMPAN</button>
            </div>
        </form>
    </div>
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
setTimeout(function () {
    let alert = document.getElementById('success');
    if (alert) {

        alert.style.transition = "opacity 0.5s ease";
        alert.style.opacity = 0;

        setTimeout(() => alert.remove(), 500);
    }
}, 3000);
</script>
@endpush
