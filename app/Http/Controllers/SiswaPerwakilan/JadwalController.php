<?php

namespace App\Http\Controllers\SiswaPerwakilan;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SiswaPerwakilan\JadwalPelajaranExport;
use Barryvdh\DomPDF\Facade\Pdf;

class JadwalController extends Controller
{
    public function exportPdf($kelasId = null)
    {
        $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat'];
        $jadwalByHari = [];

        foreach ($hariList as $hari) {
            $jadwalByHari[$hari] = [];
        }

        $kelas = null;

        if ($kelasId) {
            $kelas = Kelas::find($kelasId);

            $jadwal = JadwalPelajaran::with(['mataPelajaran', 'guru'])
                ->where('kelas_id', $kelasId)
                ->get();

            foreach ($jadwal as $j) {
                for ($i = $j->jam_mulai; $i <= $j->jam_selesai; $i++) {
                    $jadwalByHari[$j->hari][$i] = $j;
                }
            }
        }

        $pdf = Pdf::loadView('exports.pdf', compact('jadwalByHari', 'kelas'))
                ->setPaper('A4', 'landscape');
        
        return $pdf->download('jadwal-pelajaran.pdf');
    }
    public function index(Request $request)
    {
        $kelasList = Kelas::all();
        $kelasId   = $request->get('kelas_id');

        $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat'];
        $jadwalByHari = [];

        foreach ($hariList as $hari) {
            $jadwalByHari[$hari] = [];
        }

        if ($kelasId) {
            $jadwal = JadwalPelajaran::with(['mataPelajaran', 'guru'])
                        ->where('kelas_id', $kelasId)
                        ->get();

            foreach ($jadwal as $j) {
                for ($i = $j->jam_mulai; $i <= $j->jam_selesai; $i++) {
                    $jadwalByHari[$j->hari][$i] = $j;
                }
            }
        }

        return view('pages.siswa_perwakilan.jadwal.index', compact('kelasList', 'kelasId', 'jadwalByHari'));
    }
}
