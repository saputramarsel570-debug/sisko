@extends('layouts.app')

@section('title', 'Kelola Keluhan & Saran')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3 class="page-title">Kelola Keluhan & Saran</h3>

            <div class="card card-body table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Pengirim</th>
                            <th>Kategori</th>
                            <th>Isi</th>
                            <th>Status</th>
                            <th>Dikirim</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($keluhanSaran as $index => $item)
                        <tr>
                            <td>{{ $index + $keluhanSaran->firstItem() }}</td>
                            <td>{{ $item->user->name ?? '-' }}</td>
                            <td><span class="badge bg-{{ $item->kategori == 'keluhan' ? 'danger' : 'info' }}">{{ ucfirst($item->kategori) }}</span></td>
                            <td class="text-start">{{ Str::limit($item->isi, 50) }}</td>
                            <td>
                            @if ($item->status == 'pending')
                                <span class="badge bg-secondary">Pending</span>
                            @elseif ($item->status == 'proses')
                                <span class="badge bg-warning text-dark">Proses</span>
                            @else
                                <span class="badge bg-success">Selesai</span>
                            @endif
                            </td>
                            <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.keluhan_saran.show', $item->id) }}" class="btn btn-sm btn-info">
                                    <i class="ti ti-eye"></i> Lihat
                                </a>
                                <a href="{{ route('admin.keluhan_saran.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                    <i class="ti ti-edit"></i> Edit
                                </a>
                                <a href="javascript:;" class="btn btn-sm btn-danger"
                                   onclick="actionDelete('{{ route('admin.keluhan_saran.destroy', $item->id) }}')">
                                    <i class="ti ti-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada keluhan atau saran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $keluhanSaran->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
