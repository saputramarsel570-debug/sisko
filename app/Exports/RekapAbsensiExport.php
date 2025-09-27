<?php

namespace App\Exports;

use App\Models\Siswa;
use App\Models\Absensi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RekapAbsensiExport implements FromView
{
    protected $kelasId, $bulan;

    public function __construct($kelasId, $bulan)
    {
        $this->kelasId = $kelasId;
        $this->bulan   = $bulan;
    }

    public function view(): View
    {
        $siswaList = Siswa::where('kelas_id', $this->kelasId)->orderBy('nama')->get();

        $absensi = Absensi::where('kelas_id', $this->kelasId)
            ->whereMonth('tanggal', date('m', strtotime($this->bulan)))
            ->whereYear('tanggal', date('Y', strtotime($this->bulan)))
            ->get();

        $tanggalList = $absensi->pluck('tanggal')->unique()->sort();

        $rekap = [];
        $totals = [];
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

        return view('exports.rekap_absensi', [
            'siswaList'   => $siswaList,
            'tanggalList' => $tanggalList,
            'rekap'       => $rekap,
            'totals'      => $totals
        ]);
    }
}
