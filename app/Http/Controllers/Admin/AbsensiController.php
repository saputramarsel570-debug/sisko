<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Absensi;
use App\Models\Kelas;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapAbsensiExport;

class AbsensiController extends Controller
{
    public function rekap(Request $request)
    {
        $kelasId = $request->kelas_id;
        $bulan   = $request->bulan;

        $kelasList = Kelas::all();
        $siswaList = collect();
        $tanggalList = collect();
        $rekap = [];
        $totals = [];

        if ($kelasId && $bulan) {
            $siswaList = Siswa::where('kelas_id', $kelasId)->orderBy('nama')->get();

            $absensi = Absensi::where('kelas_id', $kelasId)
                ->whereMonth('tanggal', date('m', strtotime($bulan)))
                ->whereYear('tanggal', date('Y', strtotime($bulan)))
                ->get();

            $tanggalList = $absensi->pluck('tanggal')->unique()->sort();

            foreach ($absensi as $a) {
                $rekap[$a->siswa_id][$a->tanggal] = $a->status;

                if (!isset($totals[$a->siswa_id])) {
                    $totals[$a->siswa_id] = ['H' => 0, 'I' => 0, 'S' => 0, 'A' => 0];
                }
                if ($a->status == 'hadir') $totals[$a->siswa_id]['H']++;
                if ($a->status == 'izin')  $totals[$a->siswa_id]['I']++;
                if ($a->status == 'sakit') $totals[$a->siswa_id]['S']++;
                if ($a->status == 'alfa')  $totals[$a->siswa_id]['A']++;
            }
        }

        return view('admin.absensi.rekap', compact(
            'kelasList', 'siswaList', 'tanggalList', 'rekap',
            'kelasId', 'bulan', 'totals'
        ));
    }

    public function export(Request $request)
    {
        return Excel::download(new RekapAbsensiExport(
            $request->kelas_id,
            $request->bulan
        ), 'rekap_absensi.xlsx');
    }
}
