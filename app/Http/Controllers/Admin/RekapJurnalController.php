<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jurnal;
use App\Models\Kelas;
use Carbon\Carbon;

class RekapJurnalController extends Controller
{
    public function index(Request $request)
    {
        $kelasId = $request->get('kelas_id');
        $tanggal = $request->get('tanggal') ?? Carbon::today()->toDateString();

        // daftar kelas untuk dropdown
        $kelasList = Kelas::orderBy('nama_kelas')->get();

        // query jurnal
        $jurnals = collect();
        if ($kelasId) {
            $jurnals = Jurnal::with(['guru', 'mataPelajaran', 'kelas'])
                ->where('kelas_id', $kelasId)
                ->whereDate('tanggal', $tanggal)
                ->orderBy('jam_mulai')
                ->get();
        }

        return view('pages.admin.jurnal.rekap', compact(
            'kelasList',
            'kelasId',
            'tanggal',
            'jurnals'
        ));
    }
}
