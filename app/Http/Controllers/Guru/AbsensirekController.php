<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Absensi;
use App\Models\Kelas;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class AbsensirekController extends Controller
{
    public function rekap(Request $request)
    {
        $kelasId = $request->kelas_id;
        $periode = $request->periode;
        $tanggal = $request->tanggal;
        $bulan   = $request->bulan;

        $kelasList   = Kelas::orderBy('nama_kelas')->get();
        $siswaList   = collect();
        $tanggalList = collect();
        $rekap       = [];
        $hadirCounts = [];
        $totalStatus = [];

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

                $start = Carbon::createFromDate($y, $m, 1);
                $end   = $start->copy()->endOfMonth();
                $tanggalList = collect();
                while ($start <= $end) {
                    $tanggalList->push($start->toDateString());
                    $start->addDay();
                }
            } else {
                $tanggalList = $absensi->pluck('tanggal')->unique()->sort()->values();
            }

            foreach ($absensi as $a) {
                $rekap[$a->siswa_id][(string)$a->tanggal] = $a;
            }

            foreach ($siswaList as $s) {
                $totalStatus[$s->id] = [
                    'hadir' => $absensi->where('siswa_id', $s->id)->where('status', 'hadir')->count(),
                    'sakit' => $absensi->where('siswa_id', $s->id)->where('status', 'sakit')->count(),
                    'izin'  => $absensi->where('siswa_id', $s->id)->where('status', 'izin')->count(),
                    'alfa'  => $absensi->where('siswa_id', $s->id)->where('status', 'alfa')->count(),
                ];
            }
        }

        return view('pages.guru.absensirek.rekap', compact(
            'kelasList',
            'siswaList',
            'tanggalList',
            'rekap',
            'kelasId',
            'periode',
            'tanggal',
            'bulan',
            'hadirCounts',
            'totalStatus'
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
    public function exportPdf(Request $request)
{
    $kelasId = $request->kelas_id;
    $periode = $request->periode;
    $bulan   = $request->bulan;
    $tanggal = $request->tanggal ?? now()->toDateString(); // gunakan tanggal dari request jika ada

    // Pastikan data kelas dan siswa ditemukan
    $kelas = \App\Models\Kelas::findOrFail($kelasId);
    $siswaList = \App\Models\Siswa::where('kelas_id', $kelasId)->orderBy('nama')->get();

    // Query absensi sesuai filter
    $absensiQuery = \App\Models\Absensi::where('kelas_id', $kelasId);

    if ($periode === 'hari' && $tanggal) {
        $absensiQuery->whereDate('tanggal', $tanggal);
    } elseif ($periode === 'bulan' && $bulan) {
        $m = date('m', strtotime($bulan));
        $y = date('Y', strtotime($bulan));
        $absensiQuery->whereMonth('tanggal', $m)->whereYear('tanggal', $y);
    }

    $absensi = $absensiQuery->orderBy('tanggal')->get();

    // Data yang dikirim ke view PDF
    $data = [
        'kelas'     => $kelas,
        'siswaList' => $siswaList,
        'absensi'   => $absensi,
        'periode'   => $periode,
        'bulan'     => $bulan,
        'tanggal'   => $tanggal,
    ];

    // Generate PDF menggunakan DomPDF
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pages.guru.absensirek.pdf', $data)
        ->setPaper('a4', 'landscape');

    // Unduh file dengan nama yang dinamis
    return $pdf->download('Rekap-Absensi-' . $kelas->nama_kelas . '-' . now()->format('Ymd_His') . '.pdf');
}
}
