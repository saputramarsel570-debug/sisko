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
    $guru = auth()->user()->guru; // ambil guru login

    // Mode tampilan (harian/bulanan)
    $mode = $request->get('mode', 'harian');

    // Tanggal spesifik (untuk harian)
    $tanggal = $request->get('tanggal') ?? now()->toDateString();

    // Periode bulan (untuk bulanan)
    $periode = $request->get('periode') ?? now()->format('Y-m');

    // Mapping hari
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

    // === MODE HARIAN ===
    if ($mode == 'harian') {
        $jurnalHariIni = Jurnal::with(['kelas', 'mataPelajaran'])
            ->where('guru_id', $guru->id)
            ->whereDate('tanggal', $tanggal)
            ->orderBy('jam_mulai')
            ->get();

        // Jika tidak ada jurnal di tanggal itu, ambil jadwal harinya agar tetap tampil tabel kosong
        if ($jurnalHariIni->isEmpty()) {
            $hari = $hariMap[Carbon::parse($tanggal)->format('l')] ?? null;

            $jadwalHari = JadwalPelajaran::with(['kelas', 'mataPelajaran'])
                ->where('guru_id', $guru->id)
                ->where('hari', $hari)
                ->orderBy('jam_mulai')
                ->get();

            // ubah jadi format "kosong" biar tetap tampil
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

    // === MODE BULANAN ===
    if ($mode == 'bulanan') {
        [$tahun, $bulan] = explode('-', $periode);
        $tanggalAwal = Carbon::createFromDate($tahun, $bulan, 1);
        $tanggalAkhir = $tanggalAwal->copy()->endOfMonth();

        // Ambil jurnal guru login untuk bulan itu
        $jurnalBulanan = Jurnal::with(['kelas', 'mataPelajaran'])
            ->where('guru_id', $guru->id)
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('tanggal');

        // Tambahkan tanggal kosong kalau belum ada jurnal
        $periodeTanggal = Carbon::parse($tanggalAwal)->daysUntil($tanggalAkhir);
        foreach ($periodeTanggal as $tgl) {
            $key = $tgl->toDateString();
            if (!isset($jurnalBulanan[$key])) {
                // buat entri kosong
                $hari = $hariMap[$tgl->format('l')] ?? '-';
                $jurnalBulanan[$key] = collect([
                    (object)[
                        'tanggal' => $key,
                        'materi' => null,
                        'catatan' => null,
                        'kelas' => null,
                        'mataPelajaran' => null,
                        'hari' => $hari,
                    ]
                ]);
            }
        }

        // urutkan tanggal
        $jurnalBulanan = $jurnalBulanan->sortKeys();
    }

    return view('pages.guru.jurnals.rekap', compact(
        'guru', 'mode', 'tanggal', 'periode', 'jurnalHariIni', 'jurnalBulanan'
    ));
}

    public function exportPdf(Request $request)
    {
        $guru = auth()->user()->guru;
        $periode = $request->periode ?? date('Y-m');
        [$tahun, $bulan] = explode('-', $periode);

        $tanggalAwal = Carbon::createFromDate($tahun, $bulan, 1);
        $tanggalAkhir = $tanggalAwal->copy()->endOfMonth();

        $jurnalBulanan = Jurnal::with(['kelas', 'mataPelajaran'])
            ->where('guru_id', $guru->id)
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->orderBy('tanggal')
            ->get()
            ->groupBy('tanggal');

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