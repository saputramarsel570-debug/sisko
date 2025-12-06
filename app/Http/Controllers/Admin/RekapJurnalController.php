<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jurnal;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapJurnalController extends Controller
{
    public function index(Request $request)
    {
        $kelasId = $request->get('kelas_id');
        $mode = $request->get('mode', 'harian');
        $tanggal = $request->get('tanggal') ?? Carbon::today()->toDateString();
        $periode = $request->get('periode') ?? date('Y-m');

        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $jadwalGabung = collect();
        $jurnalHariIni = collect();
        $jadwalBulanan = collect();
        $jurnalBulanan = collect();

        if ($kelasId) {
            // Mapping hari Indonesia
            $hariMap = [
                'Monday'    => 'Senin',
                'Tuesday'   => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday'  => 'Kamis',
                'Friday'    => 'Jumat',
            ];

            // === MODE HARIAN ===
            if ($mode == 'harian') {
                $hariInggris = Carbon::parse($tanggal)->format('l');
                $hari = $hariMap[$hariInggris] ?? null;

                if ($hari) {
                    $jadwalHariIni = JadwalPelajaran::with(['kelas', 'mataPelajaran', 'guru'])
                        ->where('kelas_id', $kelasId)
                        ->where('hari', $hari)
                        ->orderBy('jam_mulai')
                        ->get();

                    // gabungkan jadwal berurutan sama guru & mapel
                    foreach ($jadwalHariIni as $jadwal) {
                        if ($jadwalGabung->isEmpty()) {
                            $jadwalGabung->push(clone $jadwal);
                            continue;
                        }

                        $lastIndex = $jadwalGabung->keys()->last();
                        $last = $jadwalGabung[$lastIndex];

                        if (
                            $last->guru_id == $jadwal->guru_id &&
                            $last->mata_pelajaran_id == $jadwal->mata_pelajaran_id &&
                            ($last->jam_selesai + 1) == $jadwal->jam_mulai
                        ) {
                            $last->jam_selesai = $jadwal->jam_selesai;
                            $jadwalGabung[$lastIndex] = $last;
                        } else {
                            $jadwalGabung->push(clone $jadwal);
                        }
                    }

                    $jurnalHariIni = Jurnal::where('kelas_id', $kelasId)
                        ->whereDate('tanggal', $tanggal)
                        ->get()
                        ->keyBy(function ($item) {
                            return $item->jam_mulai . '-' . $item->jam_selesai;
                        });
                }
            }

            // === MODE BULANAN ===
            if ($mode == 'bulanan') {
                [$tahun, $bulan] = explode('-', $periode);

                $tanggalAwal = Carbon::createFromDate($tahun, $bulan, 1);
                $tanggalAkhir = $tanggalAwal->copy()->endOfMonth();

                // Ambil semua jurnal bulan itu
                $jurnalBulanan = Jurnal::with(['guru', 'mataPelajaran'])
                    ->where('kelas_id', $kelasId)
                    ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
                    ->orderBy('tanggal')
                    ->get()
                    ->groupBy('tanggal');

                // Ambil jadwal tetap per hari sesuai nama hari
                $jadwalKelas = JadwalPelajaran::with(['mataPelajaran', 'guru'])
                    ->where('kelas_id', $kelasId)
                    ->orderBy('jam_mulai')
                    ->get()
                    ->groupBy('hari');

                // Buat daftar tanggal dalam sebulan
                $periodeTanggal = Carbon::parse($tanggalAwal);
                while ($periodeTanggal->lte($tanggalAkhir)) {
                    $hariInggris = $periodeTanggal->format('l');
                    $hari = $hariMap[$hariInggris] ?? null;
                    if ($hari && isset($jadwalKelas[$hari])) {
                        $jadwalBulanan[$periodeTanggal->toDateString()] = $jadwalKelas[$hari];
                    }
                    $periodeTanggal->addDay();
                }
            }
        }

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

        return view('pages.admin.jurnal.rekap', compact(
            'kelasList',
            'kelasId',
            'mode',
            'tanggal',
            'periode',
            'jadwalGabung',
            'jurnalHariIni',
            'jadwalBulanan',
            'jurnalBulanan',
            'jamRanges'
        ));
    }

    public function exportPdf(Request $request)
    {
        $kelasId = $request->kelas_id;
        $periode = $request->periode ?? date('Y-m');
        [$tahun, $bulan] = explode('-', $periode);

        $kelas = Kelas::find($kelasId);
        $hariMap = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
        ];

        $tanggalAwal = Carbon::createFromDate($tahun, $bulan, 1);
        $tanggalAkhir = $tanggalAwal->copy()->endOfMonth();

        $jurnalBulanan = Jurnal::with(['guru', 'mataPelajaran'])
            ->where('kelas_id', $kelasId)
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->orderBy('tanggal')
            ->get()
            ->groupBy('tanggal');

        $jadwalKelas = JadwalPelajaran::with(['mataPelajaran', 'guru'])
            ->where('kelas_id', $kelasId)
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        $jadwalBulanan = collect();
        $periodeTanggal = Carbon::parse($tanggalAwal);
        while ($periodeTanggal->lte($tanggalAkhir)) {
            $hariInggris = $periodeTanggal->format('l');
            $hari = $hariMap[$hariInggris] ?? null;
            if ($hari && isset($jadwalKelas[$hari])) {
                $jadwalBulanan[$periodeTanggal->toDateString()] = $jadwalKelas[$hari];
            }
            $periodeTanggal->addDay();
        }

        $data = [
            'kelas' => $kelas,
            'periode' => $periode,
            'jadwalBulanan' => $jadwalBulanan,
            'jurnalBulanan' => $jurnalBulanan,
            'jamRanges' => [
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
            ]
        ];

        $pdf = Pdf::loadView('pages.admin.jurnal.rekap_pdf', $data)
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Rekap_Jurnal_Bulan_' . $periode . '.pdf');
    }
}