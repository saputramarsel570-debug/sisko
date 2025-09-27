<?php

namespace App\Exports;

use App\Models\Siswa;
use App\Models\Absensi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RekapAbsensiExport implements FromView
{
    protected $kelasId, $periode, $tanggal, $bulan;

    public function __construct($kelasId, $periode, $tanggal, $bulan)
    {
        $this->kelasId = $kelasId;
        $this->periode = $periode;
        $this->tanggal = $tanggal;
        $this->bulan   = $bulan;
    }

    public function view(): View
    {
        $siswaList = Siswa::where('kelas_id', $this->kelasId)->orderBy('nama')->get();

        $query = Absensi::where('kelas_id', $this->kelasId);

        if ($this->periode == 'hari' && $this->tanggal) {
            $query->whereDate('tanggal', $this->tanggal);
        } elseif ($this->periode == 'bulan' && $this->bulan) {
            $m = date('m', strtotime($this->bulan));
            $y = date('Y', strtotime($this->bulan));
            $query->whereMonth('tanggal', $m)->whereYear('tanggal', $y);
        }

        $absensi = $query->orderBy('tanggal')->get();
        $tanggalList = $absensi->pluck('tanggal')->unique()->sort()->values();

        $rekap = [];
        foreach ($absensi as $a) {
            $rekap[$a->siswa_id][(string)$a->tanggal] = $a;
        }

        return view('exports.rekap_absensi', [
            'siswaList'   => $siswaList,
            'tanggalList' => $tanggalList,
            'rekap'       => $rekap
        ]);
    }
}
