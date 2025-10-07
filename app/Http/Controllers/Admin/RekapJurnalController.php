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
        $tanggal = $request->get('tanggal') ?? Carbon::today()->toDateString();

        // daftar kelas
        $kelasList = Kelas::orderBy('nama_kelas')->get();

        $jadwalGabung = collect();
        $jurnalHariIni = collect();

        if ($kelasId) {
            // mapping hari
            $hariMap = [
                'Monday'    => 'Senin',
                'Tuesday'   => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday'  => 'Kamis',
                'Friday'    => 'Jumat',
            ];

            $hariInggris = Carbon::parse($tanggal)->format('l');
            $hari = $hariMap[$hariInggris] ?? null;

            if ($hari) {
                // ambil jadwal hari itu
                $jadwalHariIni = JadwalPelajaran::with(['kelas', 'mataPelajaran', 'guru'])
                    ->where('kelas_id', $kelasId)
                    ->where('hari', $hari)
                    ->orderBy('jam_mulai')
                    ->get();

                // gabungkan jadwal berurutan sama mapel + guru
                foreach ($jadwalHariIni as $jadwal) {
                    if ($jadwalGabung->isEmpty()) {
                        $jadwalGabung->push(clone $jadwal);
                        continue;
                    }

                    $lastIndex = $jadwalGabung->keys()->last();
                    $last      = $jadwalGabung[$lastIndex];

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

                // ambil jurnal yang sudah diisi
                $jurnalHariIni = Jurnal::where('kelas_id', $kelasId)
                    ->whereDate('tanggal', $tanggal)
                    ->get()
                    ->keyBy(function ($item) {
                        return $item->jam_mulai.'-'.$item->jam_selesai;
                    });
            }
        }

        // jam ranges
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
            'tanggal',
            'jadwalGabung',
            'jurnalHariIni',
            'jamRanges'
        ));
    }
    public function exportPdf(Request $request)
    {
        $kelasId = $request->kelas_id;
        $tanggal = $request->tanggal ?? date('Y-m-d');

        // ambil data yang sama seperti tampilan normal
        $kelasList = Kelas::all();
        $jadwalGabung = JadwalPelajaran::with(['mataPelajaran', 'guru'])
            ->where('kelas_id', $kelasId)
            ->get();

        $jurnalHariIni = Jurnal::where('tanggal', $tanggal)
                            ->where('kelas_id', $kelasId)
                            ->get()
                            ->keyBy(fn($item) => $item->jam_mulai.'-'.$item->jam_selesai);

        // jam ranges (biar jam tampil sama kayak di index)
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

        $data = [
            'kelasList' => $kelasList,
            'kelasId' => $kelasId,
            'tanggal' => $tanggal,
            'jadwalGabung' => $jadwalGabung,
            'jurnalHariIni' => $jurnalHariIni,
            'jamRanges' => $jamRanges,
        ];

        $pdf = Pdf::loadView('pages.admin.jurnal.rekap_pdf', $data)
                ->setPaper('a4', 'portrait');

        return $pdf->stream('Rekap_Jurnal_' . $tanggal . '.pdf');
    }
}

