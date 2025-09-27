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

        $tanggalList = collect();

        if ($this->periode == 'hari' && $this->tanggal) {
            $tanggalList = collect([$this->tanggal]);
            $query->whereDate('tanggal', $this->tanggal);
        } elseif ($this->periode == 'bulan' && $this->bulan) {
            $month = date('m', strtotime($this->bulan));
            $year  = date('Y', strtotime($this->bulan));

            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            for ($d = 1; $d <= $daysInMonth; $d++) {
                $tanggalList->push(date('Y-m-d', strtotime("$year-$month-$d")));
            }

            $query->whereMonth('tanggal', $month)->whereYear('tanggal', $year);
        }

        $absensi = $query->get();
        $rekap = [];

        foreach ($absensi as $a) {
            $rekap[$a->siswa_id][$a->tanggal] = $a;
        }

        return view('exports.rekap_absensi', [
            'siswaList'   => $siswaList,
            'tanggalList' => $tanggalList,
            'rekap'       => $rekap
        ]);
    }
}
