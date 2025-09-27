<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Absensi;
use App\Models\Kelas;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapAbsensiExport;

class AbsensiController extends Controller
{
    public function rekap(Request $request)
    {
        $kelasId = $request->kelas_id;
        $periode = $request->periode;
        $tanggal = $request->tanggal;
        $bulan   = $request->bulan;

        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $siswaList = collect();
        $tanggalList = collect();
        $rekap = [];

        if ($kelasId) {
            $siswaList = Siswa::where('kelas_id', $kelasId)->orderBy('nama')->get();

            $query = Absensi::where('kelas_id', $kelasId);

            if ($periode === 'hari' && $tanggal) {
                $tanggalList = collect([$tanggal]);
                $query->whereDate('tanggal', $tanggal);
            } elseif ($periode === 'bulan' && $bulan) {
                $m = date('m', strtotime($bulan));
                $y = date('Y', strtotime($bulan));

                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $m, $y);
                for ($d = 1; $d <= $daysInMonth; $d++) {
                    $tanggalList->push(date('Y-m-d', strtotime("$y-$m-$d")));
                }

                $query->whereMonth('tanggal', $m)->whereYear('tanggal', $y);
            }

            $absensi = $query->get();

            foreach ($absensi as $a) {
                $rekap[$a->siswa_id][$a->tanggal] = $a;
            }
        }

        return view('pages.admin.absensi.rekap', compact(
            'kelasList',
            'siswaList',
            'tanggalList',
            'rekap',
            'kelasId',
            'periode',
            'tanggal',
            'bulan'
        ));
    }

    public function export(Request $request)
    {
        return Excel::download(new RekapAbsensiExport(
            $request->kelas_id,
            $request->periode,
            $request->tanggal,
            $request->bulan
        ), 'rekap_absensi.xlsx');
    }
}
