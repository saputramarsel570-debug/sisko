@extends('layouts.app')

@section('title', 'Detail Jadwal Ekskul')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-info text-white rounded-top-4">
                <h4 class="mb-0 fw-bold"><i class="ti ti-calendar-event"></i> Detail Jadwal Ekskul</h4>
            </div>

            <div class="card-body">
                <table class="table table-bordered mb-0">
                    <tr>
                        <th width="30%">ID</th>
                        <td>{{ $jadwal_ekskul->id }}</td>
                    </tr>
                    <tr>
                        <th>Nama Ekskul</th>
                        <td>{{ $jadwal_ekskul->ekstrakurikuler->nama }}</td>
                    </tr>
                    <tr>
                        <th>Pembina</th>
                        <td>{{ $jadwal_ekskul->ekstrakurikuler->nama_pembina ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Hari</th>
                        <td>
                            @php
                                $hariList = $jadwal_ekskul->hari;
                                if (!is_array($hariList)) {
                                    $hariList = json_decode($hariList, true) ?? [];
                                }
                            @endphp
                            @if(!empty($hariList))
                                {{ implode(', ', $hariList) }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $jadwal_ekskul->ekstrakurikuler->deskripsi ?? '-' }}</td>
                    </tr>
                    @if(!empty($jadwal_ekskul->ekstrakurikuler->foto))
                    <tr>
                        <th>Foto</th>
                        <td>
                            <img src="{{ asset('storage/' . $jadwal_ekskul->ekstrakurikuler->foto) }}"
                                 alt="Foto {{ $jadwal_ekskul->ekstrakurikuler->nama }}"
                                 class="img-fluid rounded" style="max-height: 250px;">
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <th>Dibuat Pada</th>
                        <td>{{ $jadwal_ekskul->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Diperbarui Pada</th>
                        <td>{{ $jadwal_ekskul->updated_at->format('d M Y H:i') }}</td>
                    </tr>
                </table>
            </div>

            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('admin.jadwal_ekskul.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('admin.jadwal_ekskul.edit', $jadwal_ekskul->id) }}" class="btn btn-warning text-white">
                    <i class="ti ti-pencil"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
