@extends('layouts.app')

@section('title', 'Halaman Pengumuman Siswa')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3 class="page-title">Pengumuman Sekolah</h3>

            <div class="card card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="kategori" class="form-label fw-bold">Filter</label>
                        <select class="form-select" id="kategori" name="kategori">
                            <option value="">Semua Kategori</option>
                            @foreach ($kategori as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 offset-md-4">
                        <label for="cari" class="form-label fw-bold">Cari Pengumuman</label>
                        <input type="text" id="cari" class="form-control" placeholder="Cari pengumuman...">
                    </div>
                </div>

                <table class="table table-striped dataTable">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengumuman as $index => $item)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $item->judul }}</td>
                                <td>{{ $item->kategori->nama ?? '-' }}</td>
                                <td>{{ $item->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('siswa.pengumuman.show', $item->id) }}" class="btn btn-sm btn-info">
                                        <span class="ti ti-eye"></span> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada pengumuman</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
@endpush

@push('scripts')
    <script src="{{ asset('/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script type='text/javascript'>
    $(function() {
        $('.dataTable').DataTable();
    });
    </script>
@endpush