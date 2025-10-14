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

        // Pastikan hanya role orangtua yang bisa akses
        if ($user->role !== 'orangtua') {
            abort(403, 'Akses ditolak');
        }

        $siswa = $user->orangTua->siswa;

        // Ambil filter dari request
        $bulan   = $request->input('bulan', Carbon::now()->month);
        $tahun   = $request->input('tahun', Carbon::now()->year);
        $tanggal = $request->input('tanggal'); // format YYYY-MM-DD dari input date

        // Query dasar
        $query = Absensi::where('siswa_id', $siswa->id)
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan);

        // Jika tanggal difilter, tambahkan whereDate
        if (!empty($tanggal)) {
            $query->whereDate('tanggal', $tanggal);
        }

        $absensi = $query->orderBy('tanggal', 'asc')->get();

        return view('pages.orangtua.absensi.index', compact('siswa', 'absensi', 'bulan', 'tahun', 'tanggal'));
    }
}