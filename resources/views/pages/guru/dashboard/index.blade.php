@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-4">
    <h2 class="text-center mb-5 fw-bold">Dashboard Guru</h2>

    {{-- Statistik Ringkas --}}
    <div class="row g-4 justify-content-center">
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-sm border-0 text-center bg-primary text-white rounded-4">
                <div class="card-body py-4">
                    <i class="ti ti-users fs-1 mb-2"></i>
                    <h6>Total Siswa</h6>
                    <h2 class="fw-bold">{{ $totalSiswa }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-sm border-0 text-center bg-success text-white rounded-4">
                <div class="card-body py-4">
                    <i class="ti ti-user-star fs-1 mb-2"></i>
                    <h6>Total Guru</h6>
                    <h2 class="fw-bold">{{ $totalGuru }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-sm border-0 text-center bg-warning text-dark rounded-4">
                <div class="card-body py-4">
                    <i class="ti ti-chalkboard fs-1 mb-2"></i>
                    <h6>Total Kelas</h6>
                    <h2 class="fw-bold">{{ $totalKelas }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-sm border-0 text-center bg-danger text-white rounded-4">
                <div class="card-body py-4">
                    <i class="ti ti-users-group fs-1 mb-2"></i>
                    <h6>Total Orang Tua</h6>
                    <h2 class="fw-bold">{{ $totalOrtu }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-sm border-0 text-center bg-info text-white rounded-4">
                <div class="card-body py-4">
                    <i class="ti ti-books fs-1 mb-2"></i>
                    <h6>Mata Pelajaran</h6>
                    <h2 class="fw-bold">{{ $totalMapel }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="card shadow-sm border-0 text-center bg-purple text-white rounded-4">
                <div class="card-body py-4">
                    <i class="ti ti-message fs-1 mb-2"></i>
                    <h6>Keluhan & Saran</h6>
                    <h2 class="fw-bold">{{ $totalKeluhan }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistik Grafik --}}
    <h4 class="mt-5 mb-3 fw-bold text-center">📊 Statistik</h4>
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body">
                    <h5 class="text-center mb-4 fw-bold">Siswa per Kelas</h5>
                    <canvas id="siswaChart" height="150"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-body">
                    <h5 class="text-center mb-4 fw-bold">
                        Kehadiran Siswa ({{ \Carbon\Carbon::now()->translatedFormat('F Y') }})
                    </h5>
                    <canvas id="absensiKelasChart" height="150"></canvas>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4 mt-4">
                <div class="card-body">
                    <h5 class="text-center mb-4 fw-bold">Tren Keluhan / Saran</h5>
                    <canvas id="keluhanChart" height="120"></canvas>
                </div>
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

    const absensiKelasCtx = document.getElementById('absensiKelasChart').getContext('2d');
    new Chart(absensiKelasCtx, {
        type: 'bar',
        data: {
            labels: @json($kelasAbsensiLabels),
            datasets: [
                {
                    label: 'Hadir',
                    data: @json($kelasAbsensiHadir),
                    backgroundColor: '#28a745',
                    borderRadius: 6,
                },
                {
                    label: 'Alfa',
                    data: @json($kelasAbsensiAlfa),
                    backgroundColor: '#dc3545',
                    borderRadius: 6,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: { enabled: true },
                legend: { position: 'top' }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    const keluhanCtx = document.getElementById('keluhanChart').getContext('2d');
    new Chart(keluhanCtx, {
        type: 'pie',
        data: {
            labels: @json($keluhanLabels),
            datasets: [{
                data: @json($keluhanCounts),
                backgroundColor: ['#0d6efd', '#ffc107', '#28a745', '#dc3545', '#17a2b8'],
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
