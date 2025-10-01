<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jurnal;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class JurnalController extends Controller
{
    public function index(Request $request)
    {
        $guru = Auth::user()->guru;

        // ambil kelas dari request atau default kelas pertama guru
        $kelasId = $request->get('kelas_id') ??
            JadwalPelajaran::where('guru_id', $guru->id)->pluck('kelas_id')->first();

        $kelas = Kelas::find($kelasId);

        // mapping hari
        $hariMap = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
        ];

        $hariInggris = Carbon::now()->format('l');
        $hariIni     = $hariMap[$hariInggris] ?? null;
        $tanggal     = Carbon::today()->toDateString();

        // daftar jam range (jam ke → waktu)
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

        // ambil jadwal hari ini
        $jadwalHariIni = JadwalPelajaran::with(['kelas', 'mataPelajaran', 'guru'])
            ->where('kelas_id', $kelasId)
            ->where('hari', $hariIni)
            ->orderBy('jam_mulai')
            ->get();

        // gabungkan jadwal yang sama guru + mapel + jam_ke berurutan
        $jadwalGabung = collect();
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
                // extend jam selesai
                $last->jam_selesai = $jadwal->jam_selesai;
                $jadwalGabung[$lastIndex] = $last; // replace
            } else {
                $jadwalGabung->push(clone $jadwal);
            }
        }

        // ambil jurnal hari ini, key by jam ke
        $jurnalHariIni = Jurnal::where('kelas_id', $kelasId)
            ->whereDate('tanggal', $tanggal)
            ->get()
            ->keyBy(function ($item) {
                return $item->jam_mulai . '-' . $item->jam_selesai; // jam_ke
            });

        return view('pages.guru.jurnal.index', compact(
            'kelas',
            'kelasId',
            'jadwalGabung',
            'jurnalHariIni',
            'guru',
            'tanggal',
            'jamRanges'
        ));
    }

    public function store(Request $request)
    {
        $guru    = Auth::user()->guru;
        $tanggal = Carbon::today()->toDateString();
        $data    = $request->input('jurnal', []);

        foreach ($data as $key => $value) {
            // key format: jamMulai-jamSelesai-mapelId-guruId
            [$jamMulai, $jamSelesai, $mapelId, $guruId] = explode('-', $key);

            $jamMulai   = (int) trim($jamMulai);
            $jamSelesai = (int) trim($jamSelesai);
            $mapelId    = (int) trim($mapelId);
            $guruId     = (int) trim($guruId);

            // ambil jadwal sesuai jam, guru, mapel
            $jadwal = JadwalPelajaran::where('guru_id', $guruId)
                ->where('kelas_id', $request->kelas_id)
                ->where('mata_pelajaran_id', $mapelId)
                ->where('jam_mulai', '<=', $jamMulai)
                ->where('jam_selesai', '>=', $jamSelesai)
                ->first();

            if ($jadwal) {
                // loop tiap jam agar bisa simpan satu per satu
                for ($jam = $jamMulai; $jam <= $jamSelesai; $jam++) {
                    Jurnal::updateOrCreate(
                        [
                            'tanggal' => $tanggal,
                            'jam_mulai' => $jam,
                            'jam_selesai' => $jam,
                            'guru_id' => $guruId,
                            'kelas_id' => $jadwal->kelas_id,
                            'mata_pelajaran_id' => $mapelId,
                        ],
                        [
                            'materi'  => $value['materi'] ?? '',
                            'catatan' => $value['catatan'] ?? '',
                        ]
                    );
                }
            }
        }

        return redirect()->route('guru.jurnal.index', ['kelas_id' => $request->kelas_id])
            ->with('success', 'Jurnal berhasil disimpan');
    }
}