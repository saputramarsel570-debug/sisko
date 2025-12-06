<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jurnal;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapJurnalsController extends Controller
{
    public function index(Request $request)
    {
        $guru = auth()->user()->guru;

        $mode = $request->get('mode', 'harian');
        $tanggal = $request->get('tanggal') ?? now()->toDateString();
        $periode = $request->get('periode') ?? now()->format('Y-m');

        $hariMap = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
        ];

        $jurnalHariIni = collect();
        $jurnalBulanan = collect();

        // =========================
        // MODE HARIAN
        // =========================
        if ($mode == 'harian') {
            $jurnalHariIni = $this->mergeJurnal(
                Jurnal::with(['kelas', 'mataPelajaran'])
                    ->where('guru_id', $guru->id)
                    ->whereDate('tanggal', $tanggal)
                    ->orderBy('jam_mulai')
                    ->get()
            );

            if ($jurnalHariIni->isEmpty()) {
                $hari = $hariMap[Carbon::parse($tanggal)->format('l')] ?? null;

                $jadwalHari = JadwalPelajaran::with(['kelas', 'mataPelajaran'])
                    ->where('guru_id', $guru->id)
                    ->where('hari', $hari)
                    ->orderBy('jam_mulai')
                    ->get();

                $jurnalHariIni = $jadwalHari->map(function ($jadwal) use ($tanggal, $guru) {
                    return (object) [
                        'tanggal' => $tanggal,
                        'jam_mulai' => $jadwal->jam_mulai,
                        'jam_selesai' => $jadwal->jam_selesai,
                        'materi' => null,
                        'catatan' => null,
                        'kelas' => $jadwal->kelas,
                        'mataPelajaran' => $jadwal->mataPelajaran,
                        'guru_id' => $guru->id,
                    ];
                });
            }
        }

        // =========================
        // MODE BULANAN
        // =========================
        if ($mode == 'bulanan') {
            [$tahun, $bulan] = explode('-', $periode);
            $tanggalAwal = Carbon::createFromDate($tahun, $bulan, 1);
            $tanggalAkhir = $tanggalAwal->copy()->endOfMonth();

            $jurnalBulanan = Jurnal::with(['kelas', 'mataPelajaran'])
                ->where('guru_id', $guru->id)
                ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
                ->orderBy('tanggal')
                ->orderBy('jam_mulai')
                ->get()
                ->groupBy('tanggal')
                ->map(function ($items) {
                    return $this->mergeJurnal($items);
                });

            // Tambahkan tanggal kosong
            $periodeTanggal = Carbon::parse($tanggalAwal)->daysUntil($tanggalAkhir);
            foreach ($periodeTanggal as $tgl) {
                $key = $tgl->toDateString();
                if (!isset($jurnalBulanan[$key])) {
                    $hari = $hariMap[$tgl->format('l')] ?? '-';
                    $jurnalBulanan[$key] = collect([
                        (object)[
                            'tanggal' => $key,
                            'jam_mulai' => null,
                            'jam_selesai' => null,
                            'materi' => null,
                            'catatan' => null,
                            'kelas' => null,
                            'mataPelajaran' => null,
                            'hari' => $hari,
                        ]
                    ]);
                }
            }

            $jurnalBulanan = $jurnalBulanan->sortKeys();
        }

        // =========================
        // JAM RANGE
        // =========================
        $jamRanges = [
            1 => '07:00 - 07:45',
            2 => '07:45 - 08:30',
            3 => '08:30 - 09:15',
            4 => '09:30 - 10:15',
            5 => '10:15 - 11:00',
            6 => '11:00 - 11:45',
            7 => '12:30 - 13:15',
            8 => '13:15 - 14:00',
            9 => '14:00 - 14:45',
            10 => '14:45 - 15:30',
        ];

        return view('pages.guru.jurnals.rekap', compact(
            'guru',
            'mode',
            'tanggal',
            'periode',
            'jurnalHariIni',
            'jurnalBulanan',
            'jamRanges'   // ← DITAMBAHKAN DI SINI ← FIX
        ));
    }

    // =========================
    // MERGE JURNAL
    // =========================
    private function mergeJurnal($items)
    {
        $merged = collect();

        foreach ($items as $item) {
            if ($merged->isEmpty()) {
                $merged->push(clone $item);
                continue;
            }

            $lastIndex = $merged->keys()->last();
            $last = $merged[$lastIndex];

            $lastEnd = Carbon::parse($last->jam_selesai)->format('H:i');
            $itemStart = Carbon::parse($item->jam_mulai)->format('H:i');

            $diff = Carbon::parse($lastEnd)
                ->diffInMinutes(Carbon::parse($itemStart));

            if (
                $last->kelas_id == $item->kelas_id &&
                $last->mata_pelajaran_id == $item->mata_pelajaran_id &&
                $last->materi == $item->materi &&
                $last->catatan == $item->catatan &&
                $diff <= 1
            ) {
                $last->jam_selesai = $item->jam_selesai;
                $merged[$lastIndex] = $last;
            } else {
                $merged->push(clone $item);
            }
        }

        return $merged;
    }

    // =========================
    // EXPORT PDF
    // =========================
    public function exportPdf(Request $request)
{
    $guru = auth()->user()->guru;
    $periode = $request->periode ?? date('Y-m');
    [$tahun, $bulan] = explode('-', $periode);

    $tanggalAwal = Carbon::createFromDate($tahun, $bulan, 1);
    $tanggalAkhir = $tanggalAwal->copy()->endOfMonth();

    // Ambil jurnal dan MERGE seperti tampilan web
    $jurnalBulanan = Jurnal::with(['kelas', 'mataPelajaran'])
        ->where('guru_id', $guru->id)
        ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
        ->orderBy('tanggal')
        ->orderBy('jam_mulai')
        ->get()
        ->groupBy('tanggal')
        ->map(function ($items) {
            return $this->mergeJurnal($items);
        });

    $data = [
        'guru' => $guru,
        'periode' => $periode,
        'jurnalBulanan' => $jurnalBulanan,
    ];

    $pdf = Pdf::loadView('pages.guru.jurnals.rekap_pdf', $data)
        ->setPaper('a4', 'portrait');

    return $pdf->stream('Rekap_Jurnal_' . $guru->nama . '_' . $periode . '.pdf');
}
}