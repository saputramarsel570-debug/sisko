<?php

namespace App\Http\Controllers\SiswaPerwakilan;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

        return view('pages.siswa_perwakilan.jadwal_ekskul.index', compact('kelasList', 'kelasId', 'jadwalByHari'));
    }

    public function show(JadwalEkskul $jadwal_ekskul)
    {
        $jadwal_ekskul->load('ekstrakurikuler');
        return view('pages.siswa_perwakilan.jadwal_ekskul.show', compact('jadwal_ekskul'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ekstrakurikuler_id' => 'required|exists:ekstrakurikuler,id',
            'hari' => 'required|array|min:1',
            'hari.*' => 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
        ]);

        JadwalEkskul::create([
            'ekstrakurikuler_id' => $request->ekstrakurikuler_id,
            'hari' => $request->hari,
        ]);

        return redirect()->route('siswa_perwakilan.jadwal_ekskul.index');
    }
}
