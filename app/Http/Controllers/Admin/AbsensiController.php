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

            if ($periode === 'bulan' && $bulan) {
                $m = date('m', strtotime($bulan));
                $y = date('Y', strtotime($bulan));

                // generate full tanggal dalam bulan
                $start = Carbon::createFromDate($y, $m, 1);
                $end   = $start->copy()->endOfMonth();
                $tanggalList = collect();
                while ($start <= $end) {
                    $tanggalList->push($start->toDateString());
                    $start->addDay();
                }
            } else {
                // default (harian atau data absensi biasa)
                $tanggalList = $absensi->pluck('tanggal')->unique()->sort()->values();
            }

            // build mapping absensi per siswa per tanggal
            foreach ($absensi as $a) {
                $rekap[$a->siswa_id][(string)$a->tanggal] = $a;
            }

            // hitung total semua status
            $totalStatus = [];
            foreach ($siswaList as $s) {
                $totalStatus[$s->id] = [
                    'hadir' => $absensi->where('siswa_id', $s->id)->where('status', 'hadir')->count(),
                    'sakit' => $absensi->where('siswa_id', $s->id)->where('status', 'sakit')->count(),
                    'izin'  => $absensi->where('siswa_id', $s->id)->where('status', 'izin')->count(),
                    'alfa'  => $absensi->where('siswa_id', $s->id)->where('status', 'alfa')->count(),
                ];
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
