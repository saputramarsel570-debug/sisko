<?php

namespace App\Http\Controllers\SiswaPerwakilan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Siswa;
use Carbon\Carbon;

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

        $tanggalHariIni = Carbon::now()->toDateString();
        $isWeekend = Carbon::now()->isWeekend();

        $sudahAdaAbsensi = Absensi::where('kelas_id', $kelas->id)
            ->whereDate('tanggal', $tanggalHariIni)
            ->exists();

        $absensiHariIni = Absensi::where('kelas_id', $kelas->id)
            ->where('tanggal', $tanggalHariIni)
            ->get();

        return view('pages.siswa_perwakilan.absensi.index', compact(
            'kelas', 'siswaKelas', 'absensiHariIni', 'sudahAdaAbsensi', 'isWeekend'
        ));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $siswaPerwakilan = Siswa::where('user_id', $user->id)->first();

        if (!$siswaPerwakilan) {
            abort(403, 'Anda bukan perwakilan kelas');
        }
        if (Carbon::now()->isWeekend()) {
            return redirect()->route('siswa_perwakilan.absensi.index')
                ->with('error', 'Absensi hanya bisa diisi Senin sampai Jumat');
        }

        $kelasId = $siswaPerwakilan->kelas_id;
        $tanggalHariIni = now()->toDateString();
        $sudahAda = Absensi::where('kelas_id', $kelasId)
            ->whereDate('tanggal', $tanggalHariIni)
            ->exists();

        if ($sudahAda) {
            return redirect()->route('siswa_perwakilan.absensi.index')
                ->with('error', 'Anda sudah mengisi absensi hari ini');
        }

        $request->validate([
            'absensi' => 'required|array',
            'absensi.*.status' => 'required|in:hadir,izin,sakit,alfa',
            'absensi.*.keterangan' => 'nullable|string',
        ]);

        foreach ($request->absensi as $siswa_id => $data) {
            Absensi::create([
                'tanggal' => $tanggalHariIni,
                'kelas_id' => $kelasId,
                'siswa_id' => $siswa_id,
                'status' => $data['status'],
                'keterangan' => $data['keterangan'] ?? null,
            ]);
        }

        return redirect()->route('siswa_perwakilan.absensi.index')
            ->with('success', 'Absensi berhasil disimpan');
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