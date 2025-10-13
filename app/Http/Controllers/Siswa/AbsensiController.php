<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Kelas;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $kelas = Kelas::all();
        $selectedKelas = $request->get('kelas_id');
        $periode = $request->get('periode', 'harian');
        $tanggal = $request->get('tanggal', \Carbon\Carbon::today()->format('Y-m-d'));
        $bulan = $request->get('bulan', \Carbon\Carbon::now()->month);
        $tahun = $request->get('tahun', \Carbon\Carbon::now()->year);

        $query = \App\Models\Absensi::with('siswa', 'kelas');

        if ($selectedKelas) {
            $query->where('kelas_id', $selectedKelas);
        }

        // Filter berdasarkan periode
        if ($periode === 'harian') {
            $query->whereDate('tanggal', $tanggal);
        } elseif ($periode === 'bulanan') {
            $query->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun);
        }

        $absensi = $query->orderBy('tanggal', 'desc')->get();

        return view('pages.siswa.absensi.index', compact(
            'absensi', 'kelas', 'selectedKelas', 'periode', 'tanggal', 'bulan', 'tahun'
        ));
    }
}