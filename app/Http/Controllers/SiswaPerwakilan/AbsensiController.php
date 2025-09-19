<?php

namespace App\Http\Controllers\SiswaPerwakilan;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        $mapel = MataPelajaran::all();

        return view('pages.siswa-perwakilan.absensi.index', compact('kelas', 'mapel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'tanggal' => 'required|date',
            'status.*' => 'required|in:hadir,izin,sakit,alfa',
        ]);

        foreach ($request->siswa_id as $index => $siswaId) {
            Absensi::create([
                'tanggal' => $request->tanggal,
                'kelas_id' => $request->kelas_id,
                'siswa_id' => $siswaId,
                'status' => $request->status[$index],
                'keterangan' => $request->keterangan[$index] ?? null,
            ]);
        }

        return redirect()->back()->with('success', 'Absensi berhasil disimpan.');
    }

    public function getSiswa($kelasId)
    {
        $siswa = Siswa::where('kelas_id', $kelasId)->get();
        return response()->json($siswa);
    }
}