@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="d-flex justify-content-center align-items-center">
        <div class="container">
            <h2 class="text-center mb-4 fw-bold">Dashboard Siswa</h2>
            <div class="row g-4 justify-content-center">

                <div class="col-md-3 col-sm-6">
                    <div class="card shadow-lg border-0 text-center bg-primary text-white rounded-4">
                        <div class="card-body py-4">
                            <h6 class="fw-light">Total Siswa</h6>
                            <h2 class="fw-bold">{{ $totalSiswa }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="card shadow-lg border-0 text-center bg-primary text-white rounded-4">
                        <div class="card-body py-4">
                            <h6 class="fw-light">Total Guru</h6>
                            <h2 class="fw-bold">{{ $totalGuru }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="card shadow-lg border-0 text-center bg-primary text-white rounded-4">
                        <div class="card-body py-4">
                            <h6 class="fw-light">Total Kelas</h6>
                            <h2 class="fw-bold">{{ $totalKelas }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="card shadow-lg border-0 text-center bg-primary text-white rounded-4">
                        <div class="card-body py-4">
                            <h6 class="fw-light">Total Orang Tua</h6>
                            <h2 class="fw-bold">{{ $totalOrtu }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="card shadow-lg border-0 text-center bg-primary text-white rounded-4">
                        <div class="card-body py-4">
                            <h6 class="fw-light">Mata Pelajaran</h6>
                            <h2 class="fw-bold">{{ $totalMapel }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6">
                    <div class="card shadow-lg border-0 text-center bg-primary text-white rounded-4">
                        <div class="card-body py-4">
                            <h6 class="fw-light">Keluhan & Saran</h6>
                            <h2 class="fw-bold">{{ $totalKeluhan }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-lg border-0 mt-5 rounded-4">
                <div class="card-body">
                    <h5 class="text-center mb-4 fw-bold">Statistik Siswa per Kelas</h5>
                    <canvas id="siswaChart" height="120"></canvas>
                </div>
            </div>

            <div class="card shadow-lg border-0 mt-5 rounded-4">
                <div class="card-body">
                    <h5 class="text-center mb-4 fw-bold">
                        Grafik Absensi Bulan {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                    </h5>
                    <canvas id="absensiChart" height="120"></canvas>
             </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('siswaChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($kelasLabels),
            datasets: [{
                label: 'Jumlah Siswa',
                data: @json($kelasCounts),
                backgroundColor: '#0d6efd',
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: true }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    const absensiCtx = document.getElementById('absensiChart').getContext('2d');
    new Chart(absensiCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($dataAbsensi)) !!},
            datasets: [{
                data: {!! json_encode(array_values($dataAbsensi)) !!},
                backgroundColor: ['#28a745', '#ffc107', '#17a2b8', '#dc3545'],
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: { enabled: true }
            }
        }
 });

</script>
@endpush
