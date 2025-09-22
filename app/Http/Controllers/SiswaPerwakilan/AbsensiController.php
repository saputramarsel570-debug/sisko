<?php

namespace App\Http\Controllers\SiswaPerwakilan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Siswa;

class AbsensiController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $siswaPerwakilan = Siswa::where('user_id', $user->id)->first();

        if (!$siswaPerwakilan) {
            abort(403, 'Anda bukan perwakilan kelas');
        }

        $kelas = $siswaPerwakilan->kelas;
        $siswaKelas = Siswa::where('kelas_id', $kelas->id)->get();

        $absensiHariIni = Absensi::where('kelas_id', $kelas->id)
            ->where('tanggal', now()->toDateString())
            ->get();

        return view('pages.siswa_perwakilan.absensi.index', compact('kelas', 'siswaKelas', 'absensiHariIni'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $siswaPerwakilan = Siswa::where('user_id', $user->id)->first();

        if (!$siswaPerwakilan) {
            abort(403, 'Anda bukan perwakilan kelas');
        }

        $kelasId = $siswaPerwakilan->kelas_id;

        $request->validate([
            'absensi' => 'required|array',
        ]);

        foreach ($request->absensi as $siswa_id => $data) {
            Absensi::create([
                'tanggal' => now()->toDateString(),
                'kelas_id' => $kelasId,
                'siswa_id' => $siswa_id,
                'status' => $data['status'],
                'keterangan' => $data['keterangan'] ?? null,
            ]);
        }

        return redirect()->route('siswa_perwakilan.absensi.index')
            ->with('success', 'Absensi berhasil disimpan');
    }

    public function edit(Absensi $absensi)
    {
        return view('pages.siswa_perwakilan.absensi.edit', compact('absensi'));
    }

    public function update(Request $request, Absensi $absensi)
    {
        $request->validate([
            'status' => 'required|in:hadir,izin,sakit,alfa',
            'keterangan' => 'nullable|string',
        ]);

        $absensi->update([
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('siswa_perwakilan.absensi.index')
            ->with('success', 'Absensi berhasil diperbarui');
    }
}