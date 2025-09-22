<?php

namespace App\Http\Controllers\SiswaPerwakilan;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\OrangTua;
use App\Models\MataPelajaran;
use App\Models\KeluhanSaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = Siswa::count();
        $totalGuru = Guru::count();
        $totalKelas = Kelas::count();
        $totalOrtu = OrangTua::count();
        $totalMapel = MataPelajaran::count();
        $totalKeluhan = KeluhanSaran::count();

        $kelasLabels = Kelas::pluck('nama_kelas');
        $kelasCounts = Kelas::withCount('siswa')->pluck('siswa_count');

        return view('pages.siswa_perwakilan.dashboard.index', compact('totalSiswa', 'totalGuru', 'totalKelas', 'totalOrtu', 'totalMapel', 'totalKeluhan', 'kelasLabels', 'kelasCounts'));
    }
}
