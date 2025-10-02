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
        $tanggal = $request->get('tanggal', Carbon::today()->toDateString());
        $kelasId = $request->get('kelas_id');

        $kelasList = Kelas::all();

        $jurnalQuery = Jurnal::with(['guru', 'kelas', 'mataPelajaran'])
            ->whereDate('tanggal', $tanggal);

        if ($kelasId) {
            $jurnalQuery->where('kelas_id', $kelasId);
        }

        $jurnal = $jurnalQuery
            ->orderBy('kelas_id')
            ->orderBy('jam_mulai')
            ->get();

        return view('pages.admin.rekap-jurnal.index', compact(
            'jurnal',
            'tanggal',
            'kelasId',
            'kelasList'
        ));
    }
}
