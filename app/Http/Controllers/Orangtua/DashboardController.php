<?php

namespace App\Http\Controllers\Orangtua;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\OrangTua;
use App\Models\MataPelajaran;
use App\Models\KeluhanSaran;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // statistik umum
        $totalSiswa = Siswa::count();
        $totalGuru = Guru::count();
        $totalKelas = Kelas::count();
        $totalOrtu = OrangTua::count();
        $totalMapel = MataPelajaran::count();
        $totalKeluhan = KeluhanSaran::count();

        $kelasLabels = Kelas::pluck('nama_kelas');
        $kelasCounts = Kelas::withCount('siswa')->pluck('siswa_count');

        // dapatkan siswa (anak) dari orangtua yang login
        $orangtua = Auth::user()->orangtua ?? null;
        $anak = $orangtua ? $orangtua->siswa : null;

        // bulan & tahun sekarang
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        // default data absensi (agar selalu ada nilainya)
        $dataAbsensi = [
            'Hadir' => 0,
            'Izin'  => 0,
            'Sakit' => 0,
            'Alfa'  => 0,
        ];

        if ($anak) {
            $rekap = Absensi::where('siswa_id', $anak->id)
                ->whereMonth('tanggal', $bulanIni)
                ->whereYear('tanggal', $tahunIni)
                ->selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status')
                ->toArray();

            // normalisasi key (database mungkin menyimpan 'hadir' lowercase dsb)
            foreach ($rekap as $status => $count) {
                $s = strtolower($status);
                if ($s === 'hadir') $dataAbsensi['Hadir'] = (int) $count;
                elseif ($s === 'izin') $dataAbsensi['Izin'] = (int) $count;
                elseif ($s === 'sakit') $dataAbsensi['Sakit'] = (int) $count;
                elseif ($s === 'alfa' || $s === 'alpha' || $s === 'alpa') $dataAbsensi['Alfa'] = (int) $count;
                // kalau ada status lain, bisa di-handle di sini
            }
        }

        return view(
            'pages.orangtua.dashboard.index',
            compact(
                'totalSiswa',
                'totalGuru',
                'totalKelas',
                'totalOrtu',
                'totalMapel',
                'totalKeluhan',
                'kelasLabels',
                'kelasCounts',
                'anak',
                'dataAbsensi'
            )
        );
    }
}