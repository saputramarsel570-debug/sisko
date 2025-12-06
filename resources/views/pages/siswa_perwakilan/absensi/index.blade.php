@extends('layouts.app-siswa_perwakilan')

@section('title', 'Absensi Hari Ini')

@section('content')
<div class="row">
    <div class="col-md-12">

        <div class="card shadow-sm border-0 mb-4">

            {{-- HEADER --}}
            <div class="card-header bg-primary text-white py-3">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                    <div>
                        @if (session('success'))
                        <div id="success" class="alert alert-solid-success d-flex align-items-center" role="alert">
                          <span class="alert-icon rounded"><i class="ti ti-check"></i></span>
                          {{ session('success') }}
                        </div>
                      @endif
                        <h5 class="mb-1 d-flex align-items-center gap-2">
                            <i class="ti ti-clipboard-list fs-4"></i>
                            Absensi Hari Ini
                        </h5>
                        <div class="small">
                            <i class="ti ti-calendar"></i> 
                            Tanggal: <strong>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</strong>
                            <span class="mx-2">|</span>
                            <i class="ti ti-building"></i> 
                            Kelas: <strong>{{ $kelas->nama_kelas }}</strong>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('siswa_perwakilan.absensi.rekap') }}" class="btn btn-light btn-sm">
                            <i class="ti ti-table"></i> Lihat Rekap
                        </a>
                    </div>
                </div>
            </div>

            {{-- BODY --}}
            <div class="card-body">

                {{-- WEEKEND --}}
                @if($isWeekend)
                    <div class="alert alert-warning">
                        <i class="ti ti-ban"></i> Hari ini libur (Sabtu/Minggu). Absensi tidak dapat diisi.
                    </div>

                {{-- SUDAH ABSEN --}}
                @elseif($sudahAdaAbsensi)
                    <div class="alert alert-success">
                        <i class="ti ti-check"></i> Absensi untuk hari ini sudah diisi.
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($absensiHariIni as $i => $absen)
                                <tr>
                                    <td>{{ $i+1 }}</td>
                                    <td class="text-start">{{ $absen->siswa->nama }}</td>
                                    <td>{{ ucfirst($absen->status) }}</td>
                                    <td>{{ $absen->keterangan ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                @else

                {{-- FORM ABSENSI --}}
                <form method="POST"> action="{{ route('siswa_perwakilan.absensi.store') }}" 
                    @csrf

                    <div class="table-responsive mt-3">
                        <table class="table table-bordered align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($siswaKelas as $i => $s)
                                <tr>
                                    <td>{{ $i+1 }}</td>

                                    <td class="text-start">{{ $s->nama }}</td>

                                    {{-- STATUS --}}
                                    <td>

                                        <select 
                                            name="absensi[{{ $s->id }}][status]"
                                            class="form-select @error('absensi.'.$s->id.'.status') is-invalid @enderror"
                                            required
                                        >
                                            <option value="">-- pilih --</option>
                                            <option value="hadir" {{ old("absensi.$s->id.status") == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                            <option value="izin"  {{ old("absensi.$s->id.status") == 'izin'  ? 'selected' : '' }}>Izin</option>
                                            <option value="sakit" {{ old("absensi.$s->id.status") == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                            <option value="alfa"  {{ old("absensi.$s->id.status") == 'alfa'  ? 'selected' : '' }}>Alfa</option>
                                        </select>

                                        {{-- ERROR STATUS --}}
                                        @error('absensi.'.$s->id.'.status')
                                            <div class="invalid-feedback d-block mt-1">
                                                <i class="ti ti-alert-triangle"></i> {{ $message }}
                                            </div>
                                        @enderror
                                    </td>

                                    {{-- KETERANGAN --}}
                                    <td>
                                        <input
                                            type="text"
                                            name="absensi[{{ $s->id }}][keterangan]"
                                            class="form-control @error('absensi.'.$s->id.'.keterangan') is-invalid @enderror"
                                            value="{{ old("absensi.$s->id.keterangan") }}"
                                            placeholder="Opsional"
                                        >

                                        @error('absensi.'.$s->id.'.keterangan')
                                            <div class="invalid-feedback d-block mt-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy"></i> Simpan Absensi
                        </button>
                    </div>

                </form>
                @endif
            </div>
        </div>
    </div>
</div>
<form id="form-delete" action="" method="POST" class="d-none">
    @csrf
    @method('DELETE')
  </form>
  @endsection
  
  @push('styles')
  <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
  <link rel="stylesheet" href="{{ asset('/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
  <link rel="stylesheet" href="{{ asset('/vendor/libs/sweetalert2/sweetalert2.css') }}" />
  <style>
    .hover-card:hover {
      transform: translateY(-4px);
      transition: all 0.25s ease;
      box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    }
  
    .bg-success-subtle { background-color: #e8f8ef !important; }
    .bg-danger-subtle { background-color: #fdeaea !important; }
  
    .btn.disabled {
      opacity: 0.6;
      pointer-events: none;
    }
  </style>
  @endpush
  
  @push('scripts')
  <script src="{{ asset('/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
  <script>
  function actionDelete(url) {
    Swal.fire({
      title: "Yakin mau dihapus?",
      text: "Data yang dihapus tidak dapat dikembalikan!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya, hapus!",
      cancelButtonText: "Batal",
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33"
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('form-delete').setAttribute('action', url);
        document.getElementById('form-delete').submit();
      }
    });
  }
  
  setTimeout(() => {
    const alert = document.getElementById('success');
    if (alert) {
      alert.style.transition = "opacity 0.5s";
      alert.style.opacity = 0;
      setTimeout(() => alert.remove(), 500);
    }
  }, 3000);
  </script>
  @endpush