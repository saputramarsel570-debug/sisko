<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\OrangTua;
use App\Models\MataPelajaran;
use App\Models\KeluhanSaran;
use App\Models\Ekstrakurikuler;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = Siswa::count();
        $totalGuru = Guru::count();
        $totalKelas = Kelas::count();
        $totalOrtu = OrangTua::count();
        $totalMapel = MataPelajaran::count();
        $totalEkstrakurikuler = Ekstrakurikuler::count();

        $kelasLabels = Kelas::pluck('nama_kelas');
        $kelasCounts = Kelas::withCount('siswa')->pluck('siswa_count');

        $bulan = Carbon::now()->month;
        $tahun = Carbon::now()->year;

        $rekapAbsensi = Kelas::with(['siswa.absensi' => function ($q) use ($bulan, $tahun) {
            $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
        }])->get();

        $kelasAbsensiLabels = [];
        $kelasAbsensiHadir = [];
        $kelasAbsensiAlfa = [];

        foreach ($rekapAbsensi as $kelas) {
            $kelasAbsensiLabels[] = $kelas->nama_kelas;
            $hadir = 0;
            $alfa = 0;

            foreach ($kelas->siswa as $siswa) {
                $hadir += $siswa->absensi->where('status', 'hadir')->count();
                $alfa += $siswa->absensi->where('status', 'alfa')->count();
            }

            $kelasAbsensiHadir[] = $hadir;
            $kelasAbsensiAlfa[] = $alfa;
        }

        $keluhanTren = KeluhanSaran::select('kategori')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('kategori')
            ->orderByDesc('total')
            ->get();

        $keluhanLabels = $keluhanTren->pluck('kategori');
        $keluhanCounts = $keluhanTren->pluck('total');

        $mapelDistribusi = Guru::join('mata_pelajaran', 'guru.mata_pelajaran_id', '=', 'mata_pelajaran.id')
            ->select('mata_pelajaran.nama_mapel', DB::raw('COUNT(guru.id) as total'))
            ->groupBy('mata_pelajaran.nama_mapel')
            ->orderByDesc('total')
            ->get();

        $mapelLabels = $mapelDistribusi->pluck('nama_mapel');
        $mapelCounts = $mapelDistribusi->pluck('total');

        return view('pages.guru.dashboard.index', compact(
            'totalSiswa',
            'totalGuru',
            'totalKelas',
            'totalOrtu',
            'totalMapel',
            'totalEkstrakurikuler',
            'kelasLabels',
            'kelasCounts',
            'kelasAbsensiLabels',
            'kelasAbsensiHadir',
            'kelasAbsensiAlfa',
            'keluhanLabels',
            'keluhanCounts',
            'mapelLabels',
            'mapelCounts'
        ));
    }
}
