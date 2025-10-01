<?php

namespace App\Http\Controllers\SiswaPerwakilan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Kelas;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    // Halaman absensi default (punya kamu sebelumnya)
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

    // Rekap absensi (harian & bulanan)
    public function rekap(Request $request)
    {
        $user = auth()->user();
        $siswaPerwakilan = Siswa::where('user_id', $user->id)->first();
        if (!$siswaPerwakilan) {
            abort(403, 'Anda bukan perwakilan kelas');
        }

        $kelasId = $request->kelas_id;
        $periode = $request->periode;
        $bulan   = $request->bulan;
        $tanggal = now()->toDateString(); // default hari ini

        $kelasList   = Kelas::orderBy('nama_kelas')->get();
        $siswaList   = collect();
        $tanggalList = collect();
        $rekap       = [];
        $totalStatus = [];

        if ($kelasId) {
            $siswaList = Siswa::where('kelas_id', $kelasId)->orderBy('nama')->get();

            $query = Absensi::where('kelas_id', $kelasId);

            if ($periode === 'hari') {
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
                if ($tanggalList->isEmpty()) {
                    $tanggalList = collect([$tanggal]); // minimal tampil hari ini
                }
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

        return view('pages.siswa_perwakilan.absensi.rekap', compact(
            'kelasList',
            'siswaList',
            'tanggalList',
            'rekap',
            'kelasId',
            'periode',
            'tanggal',
            'bulan',
            'totalStatus'
        ));
    }

    // Simpan absensi pertama kali
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

    // Update satuan
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

    // Update banyak langsung di tabel harian
    public function updateBulk(Request $request)
{
    $kelasId = $request->kelas_id;
    $tanggal = $request->tanggal;
    $absensiData = $request->absensi ?? [];

    foreach ($absensiData as $siswaId => $data) {
        \App\Models\Absensi::updateOrCreate(
            [
                'siswa_id' => $siswaId,
                'tanggal' => $tanggal,
            ],
            [
                'status' => $data['status'] ?? null,
                'keterangan' => $data['keterangan'] ?? null,
            ]
        );
    }

    return redirect()
        ->route('siswa_perwakilan.absensi.rekap', [
            'kelas_id' => $kelasId,
            'periode' => 'hari',
            'tanggal' => $tanggal,
        ])
        ->with('success', 'Absensi telah diubah ✅');
}
}