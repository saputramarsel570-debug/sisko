<?php

namespace App\Http\Controllers\SiswaPerwakilan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Kelas;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class AbsensiController extends Controller
{
    // Halaman absensi default (index)
    public function index(Request $request)
{
    $user = auth()->user();

    // Ambil kelas dari siswa perwakilan yang login
    $kelasId = optional($user->siswa->kelas)->id;

    // Kalau nggak ada kelas, tampilkan pesan
    if (!$kelasId) {
        return back()->with('error', 'Data kelas siswa perwakilan tidak ditemukan.');
    }

    $periode = $request->get('periode', 'hari');
    $tanggal = $request->get('tanggal', now()->toDateString());
    $bulan = $request->get('bulan', now()->format('Y-m'));

    // Ambil data sesuai periode
    if ($periode === 'hari') {
        $tanggalList = [$tanggal];
    } else {
        $tanggalList = \Carbon\CarbonPeriod::create(
            \Carbon\Carbon::parse($bulan . '-01'),
            \Carbon\Carbon::parse($bulan . '-01')->endOfMonth()
        )->toArray();
        $tanggalList = array_map(fn($d) => $d->format('Y-m-d'), $tanggalList);
    }

    // Ambil siswa & absensi berdasarkan kelas
    $siswaList = \App\Models\Siswa::where('kelas_id', $kelasId)->get();
    $absensi = \App\Models\Absensi::whereIn('siswa_id', $siswaList->pluck('id'))
        ->whereIn('tanggal', $tanggalList)
        ->get();

    // Buat array rekap
    $rekap = [];
    $totalStatus = [];

    foreach ($absensi as $a) {
        $rekap[$a->siswa_id][$a->tanggal] = $a;
        $status = strtolower($a->status);
        $totalStatus[$a->siswa_id][$status] = ($totalStatus[$a->siswa_id][$status] ?? 0) + 1;
    }

    return view('pages.siswa_perwakilan.absensi.rekap', compact(
        'siswaList', 'rekap', 'tanggalList', 'periode', 'tanggal', 'bulan', 'totalStatus', 'kelasId'
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

        // Otomatis ambil kelas dari siswa perwakilan
        $kelasId = $siswaPerwakilan->kelas_id;

        // Jika user masih bisa memilih manual, tapi default-nya tetap kelas perwakilan
        if ($request->filled('kelas_id')) {
            $kelasId = $request->kelas_id;
        }

        $periode = $request->periode;
        $bulan   = $request->bulan;
        $tanggal = $request->tanggal ?? now()->toDateString();

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
                    $tanggalList = collect([$tanggal]);
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
            'kelasList', 'siswaList', 'tanggalList', 'rekap',
            'kelasId', 'periode', 'tanggal', 'bulan', 'totalStatus'
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
            Absensi::updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'tanggal' => $tanggal,
                ],
                [
                    'status' => $data['status'] ?? null,
                    'keterangan' => $data['keterangan'] ?? null,
                    'kelas_id' => $kelasId,
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

    // Export PDF
    public function exportPdf(Request $request)
{
    $kelasId = $request->kelas_id;
    $periode = $request->periode;
    $bulan   = $request->bulan;
    $tanggal = now()->toDateString();

    $kelas = Kelas::findOrFail($kelasId);
    $siswaList = Siswa::where('kelas_id', $kelasId)->orderBy('nama')->get();

    $absensiQuery = Absensi::where('kelas_id', $kelasId);

    if ($periode === 'hari') {
        $absensiQuery->whereDate('tanggal', $tanggal);
    } elseif ($periode === 'bulan' && $bulan) {
        $m = date('m', strtotime($bulan));
        $y = date('Y', strtotime($bulan));
        $absensiQuery->whereMonth('tanggal', $m)->whereYear('tanggal', $y);
    }

    $absensi = $absensiQuery->orderBy('tanggal')->get();

    // 🔹 Generate tanggalList
    if ($periode === 'bulan' && $bulan) {
        $m = date('m', strtotime($bulan));
        $y = date('Y', strtotime($bulan));

        $start = \Carbon\Carbon::createFromDate($y, $m, 1);
        $end   = $start->copy()->endOfMonth();
        $tanggalList = collect();

        while ($start <= $end) {
            $tanggalList->push($start->toDateString());
            $start->addDay();
        }
    } else {
        $tanggalList = $absensi->pluck('tanggal')->unique()->sort()->values();
        if ($tanggalList->isEmpty()) {
            $tanggalList = collect([$tanggal]);
        }
    }

    // 🔹 Bentuk rekap & total
    $rekap = [];
    $totalStatus = [];

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

    $data = [
        'kelas' => $kelas,
        'siswaList' => $siswaList,
        'rekap' => $rekap,
        'tanggalList' => $tanggalList,
        'totalStatus' => $totalStatus,
        'periode' => $periode,
        'bulan' => $bulan,
        'tanggal' => $tanggal,
    ];

    $pdf = Pdf::loadView('pages.siswa_perwakilan.absensi.pdf', $data)
        ->setPaper('a4', 'landscape');

    return $pdf->download('Rekap-Absensi-' . $kelas->nama_kelas . '.pdf');
}
}