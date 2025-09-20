<?php

namespace App\Http\Controllers\OrangTua;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Absensi;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'orangtua') {
            abort(403, 'Akses ditolak');
        }

        $siswa = $user->orangTua->siswa;

        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);

        $absensi = Absensi::where('siswa_id', $siswa->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('pages.orangtua.absensi.index', compact('siswa', 'absensi', 'bulan', 'tahun'));
    }
}