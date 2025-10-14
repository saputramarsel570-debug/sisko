@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
/* --- Untuk Animasi Masuk --- */
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fadeInUp {
  animation: fadeInUp 0.8s ease;
}

/* --- Untuk Hover Card Statistik --- */
.stat-card {
  transition: all 0.3s ease;
  border: none;
  color: white;
}
.stat-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}

/* --- Untuk Gradient Warna Tiap Card --- */
.bg-gradient-primary { background: linear-gradient(135deg, #007bff, #00b4d8); }
.bg-gradient-success { background: linear-gradient(135deg, #28a745, #20c997); }
.bg-gradient-warning { background: linear-gradient(135deg, #ffc107, #ffb347); }
.bg-gradient-danger { background: linear-gradient(135deg, #dc3545, #ff6b6b); }
.bg-gradient-info { background: linear-gradient(135deg, #17a2b8, #20c997); }
.bg-gradient-purple { background: linear-gradient(135deg, #6f42c1, #a66dd4); }

.card-body h2 {
  font-size: 2.2rem;
  font-weight: 800;
}

.chart-card {
  background: #f8f9fa;
  border-radius: 20px;
  padding: 20px;
  height: 100%;
  transition: box-shadow 0.3s ease;
}
.chart-card:hover {
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}
</style>

<div class="container py-4 animate-fadeInUp">
    <h2 class="text-center mb-5 fw-bold">
        <i class="ti ti-dashboard text-primary"></i> Dashboard Admin
    </h2>

    {{-- Untuk Statistik Card --}}
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 justify-content-center">
        <div class="col">
            <div class="card stat-card bg-gradient-primary text-center rounded-4">
                <div class="card-body py-4">
                    <i class="ti ti-users fs-1 mb-2"></i>
                    <h6>Total Siswa</h6>
                    <h2>{{ $totalSiswa }}</h2>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card stat-card bg-gradient-success text-center rounded-4">
                <div class="card-body py-4">
                    <i class="ti ti-user-star fs-1 mb-2"></i>
                    <h6>Total Guru</h6>
                    <h2>{{ $totalGuru }}</h2>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card stat-card bg-gradient-warning text-center rounded-4">
                <div class="card-body py-4">
                    <i class="ti ti-chalkboard fs-1 mb-2"></i>
                    <h6>Total Kelas</h6>
                    <h2>{{ $totalKelas }}</h2>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card stat-card bg-gradient-danger text-center rounded-4">
                <div class="card-body py-4">
                    <i class="ti ti-users-group fs-1 mb-2"></i>
                    <h6>Total Orang Tua</h6>
                    <h2>{{ $totalOrtu }}</h2>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card stat-card bg-gradient-info text-center rounded-4">
                <div class="card-body py-4">
                    <i class="ti ti-books fs-1 mb-2"></i>
                    <h6>Mata Pelajaran</h6>
                    <h2>{{ $totalMapel }}</h2>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card stat-card bg-gradient-purple text-center rounded-4">
                <div class="card-body py-4">
                    <i class="ti ti-award fs-1 mb-2"></i>
                    <h6>Total Ekskul</h6>
                    <h2>{{ $totalEkstrakurikuler }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Untuk Statistik Grafik --}}
    <h4 class="mt-5 mb-4 fw-bold text-center">
        <i class="ti ti-chart-bar text-primary"></i> Statistik Visual
    </h4>
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="chart-card">
                <h5 class="text-center mb-3 fw-bold">Siswa per Kelas</h5>
                <div style="height: 300px;">
                    <canvas id="siswaChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="chart-card">
                <h5 class="text-center mb-3 fw-bold">
                    Kehadiran Siswa ({{ \Carbon\Carbon::now()->translatedFormat('F Y') }})
                </h5>
                <div style="height: 300px;">
                    <canvas id="absensiKelasChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="chart-card">
                <h5 class="text-center mb-3 fw-bold">Tren Keluhan / Saran</h5>
                <div style="height: 300px;">
                    <canvas id="keluhanChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="chart-card">
                <h5 class="text-center mb-3 fw-bold">Distribusi Guru per Mapel</h5>
                <div style="height: 300px;">
                    <canvas id="mapelChart"></canvas>
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
            maintainAspectRatio: false,
            plugins: { legend: { display: false }, tooltip: { enabled: true } },
            scales: { y: { beginAtZero: true } }
        }
    });

    const absensiCtx = document.getElementById('absensiKelasChart').getContext('2d');
    new Chart(absensiCtx, {
        type: 'bar',
        data: {
            labels: @json($kelasAbsensiLabels),
            datasets: [
                { label: 'Hadir', data: @json($kelasAbsensiHadir), backgroundColor: '#28a745', borderRadius: 6 },
                { label: 'Alfa', data: @json($kelasAbsensiAlfa), backgroundColor: '#dc3545', borderRadius: 6 }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'top' } },
            scales: { y: { beginAtZero: true } }
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
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });

    const mapelCtx = document.getElementById('mapelChart').getContext('2d');
    new Chart(mapelCtx, {
        type: 'bar',
        data: {
            labels: @json($mapelLabels),
            datasets: [{
                label: 'Jumlah Guru',
                data: @json($mapelCounts),
                backgroundColor: '#6f42c1',
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
@endpush
