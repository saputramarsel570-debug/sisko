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
    
        // Ambil tanggal
        $tanggal = $request->get('tanggal') ?? now()->toDateString();
        $hariInggris = Carbon::parse($tanggal)->format('l');
    
        // Map hari
        $hariMap = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu',
        ];
        $hariIni = $hariMap[$hariInggris] ?? null;
    
        // Ambil kelas
        $kelasId = $request->get('kelas_id')
            ?? JadwalPelajaran::where('guru_id', $guru->id)->pluck('kelas_id')->first();
    
        $kelas = Kelas::find($kelasId);
    
        // Jam real
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
    
        // Ambil jadwal
        $jadwalHariIni = JadwalPelajaran::with(['kelas', 'mataPelajaran', 'guru'])
            ->where('kelas_id', $kelasId)
            ->where('hari', $hariIni)
            ->orderBy('jam_mulai')
            ->get();
    
        // Gabungkan jadwal berurutan
        $jadwalGabung = collect();
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
    
        // Ambil jurnal per-jam
        $jurnalRaw = Jurnal::where('kelas_id', $kelasId)
            ->where('guru_id', $guru->id)
            ->whereDate('tanggal', $tanggal)
            ->get();

        // 🔥 Gabungkan jurnal sesuai format key Blade:
        // key = jamMulai-jamSelesai-mapelId-guruId
        $jurnalMerged = collect();

        foreach ($jurnalRaw as $item) {
            // Cari jadwalGabung yang cocok
            foreach ($jadwalGabung as $j) {
                if (
                    $item->jam_mulai >= $j->jam_mulai &&
                    $item->jam_mulai <= $j->jam_selesai &&
                    $item->mata_pelajaran_id == $j->mata_pelajaran_id &&
                    $item->guru_id == $j->guru_id
                ) {
                    $key = $j->jam_mulai . '-' . $j->jam_selesai . '-' . $j->mata_pelajaran_id . '-' . $j->guru_id;

                    if (!$jurnalMerged->has($key)) {
                        $jurnalMerged->put($key, $item); 
                    }
                }
            }
        }
    
        return view('pages.guru.jurnal.index', compact(
            'kelas',
            'kelasId',
            'jadwalGabung',
            'jurnalMerged',
            'guru',
            'tanggal',
            'jamRanges'
        ));
    }

    public function store(Request $request)
    {
        $guru = Auth::user()->guru;

        $tanggal = $request->input('tanggal', now()->toDateString());
        $data = $request->input('jurnal', []);

        foreach ($data as $key => $value) {

            // Key format: jamMulai-jamSelesai-mapelId-guruId
            [$jamMulai, $jamSelesai, $mapelId, $guruId] = explode('-', $key);

            $jamMulai   = (int) trim($jamMulai);
            $jamSelesai = (int) trim($jamSelesai);
            $mapelId    = (int) trim($mapelId);
            $guruId     = (int) trim($guruId);

            // Simpan jurnal per-jam sesuai jam gabungan
            for ($jam = $jamMulai; $jam <= $jamSelesai; $jam++) {
                Jurnal::updateOrCreate(
                    [
                        'tanggal' => $tanggal,
                        'jam_mulai' => $jam,
                        'jam_selesai' => $jam,
                        'guru_id' => $guruId,
                        'kelas_id' => $request->kelas_id,
                        'mata_pelajaran_id' => $mapelId,
                    ],
                    [
                        'materi'  => $value['materi'] ?? '',
                        'catatan' => $value['catatan'] ?? '',
                    ]
                );
            }
        }

        return redirect()->route('guru.jurnal.index', [
            'kelas_id' => $request->kelas_id,
            'tanggal'  => $tanggal,
        ])->with('success', 'Jurnal berhasil disimpan.');
    }
}