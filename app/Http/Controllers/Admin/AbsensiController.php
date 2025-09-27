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
        $hadirCounts = [];

        if ($kelasId) {
            $siswaList = Siswa::where('kelas_id', $kelasId)->orderBy('nama')->get();

            $query = Absensi::where('kelas_id', $kelasId);

            if ($periode === 'hari' && $tanggal) {
                $query->whereDate('tanggal', $tanggal);
            } elseif ($periode === 'bulan' && $bulan) {
                $m = date('m', strtotime($bulan));
                $y = date('Y', strtotime($bulan));
                $query->whereMonth('tanggal', $m)->whereYear('tanggal', $y);
            }

            $absensi = $query->orderBy('tanggal')->get();

            $tanggalList = $absensi->pluck('tanggal')->unique()->sort()->values();

            foreach ($absensi as $a) {
                $rekap[$a->siswa_id][(string)$a->tanggal] = $a;
            }

            foreach ($siswaList as $s) {
                $hadirCounts[$s->id] = $absensi->where('siswa_id', $s->id)->where('status', 'hadir')->count();
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
            'bulan',
            'hadirCounts'
        ));
    }

    public function export(Request $request)
    {
        return Excel::download(new RekapAbsensiExport(
            $request->kelas_id,
            $request->periode,
            $request->tanggal,
            $request->bulan
        ), 'rekap_absensi_'.now()->format('Ymd_His').'.xlsx');
    }
}
