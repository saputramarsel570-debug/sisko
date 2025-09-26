<?php

namespace App\Http\Controllers\Guru;

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

        $query = Absensi::with('siswa', 'kelas')
            ->whereDate('tanggal', Carbon::today());

        if ($selectedKelas) {
            $query->where('kelas_id', $selectedKelas);
        }

        $absensi = $query->get();

        return view('pages.guru.absensi.index', compact('absensi', 'kelas', 'selectedKelas'));
    }

    public function show(Request $request)
    {
        $kelas = Kelas::all();
        $selectedKelas = $request->get('kelas_id');

        $query = Absensi::with('siswa', 'kelas');

        if ($selectedKelas) {
            $query->where('kelas_id', $selectedKelas);
        }

        $absensi = $query->orderBy('tanggal', 'desc')->get();

        return view('pages.guru.absensi.show', compact('absensi', 'kelas', 'selectedKelas'));
    }
}