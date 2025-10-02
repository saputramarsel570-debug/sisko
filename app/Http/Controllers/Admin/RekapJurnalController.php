<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jurnal;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use Carbon\Carbon;

class JurnalController extends Controller
{
    public function rekap(Request $request)
    {
        $kelasId = $request->get('kelas_id');
        $tanggal = $request->get('tanggal') ?? Carbon::today()->toDateString();

        $kelasList = Kelas::all();
        $kelas = $kelasId ? Kelas::find($kelasId) : null;

        $hariMap = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
        ];

        $hariInggris = Carbon::parse($tanggal)->format('l');
        $hari        = $hariMap[$hariInggris] ?? null;

        $jadwalHariIni = collect();
        $jurnalHariIni = collect();

        if ($kelasId) {
            // ambil jadwal berdasarkan hari
            $jadwalHariIni = JadwalPelajaran::with(['guru', 'mataPelajaran', 'kelas'])
                ->where('kelas_id', $kelasId)
                ->where('hari', $hari)
                ->orderBy('jam_mulai')
                ->get();

            // ambil jurnal berdasarkan tanggal
            $jurnalHariIni = Jurnal::where('kelas_id', $kelasId)
                ->whereDate('tanggal', $tanggal)
                ->get()
                ->keyBy(function ($item) {
                    return $item->jam_mulai.'-'.$item->jam_selesai;
                });
        }

        return view('pages.admin.jurnal.rekap', compact(
            'kelasList',
            'kelas',
            'kelasId',
            'tanggal',
            'jadwalHariIni',
            'jurnalHariIni'
        ));
    }
}
