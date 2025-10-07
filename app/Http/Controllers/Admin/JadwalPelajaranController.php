<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Guru;
use Illuminate\Http\Request;
use App\Imports\JadwalPelajaranImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\JadwalPelajaranExport;
use Barryvdh\DomPDF\Facade\Pdf;

class JadwalPelajaranController extends Controller
{
    public function exportPdf($kelasId = null)
    {
        $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat'];
        $jadwalByHari = [];

        foreach ($hariList as $hari) {
            $jadwalByHari[$hari] = [];
        }

        $kelas = null;

        if ($kelasId) {
            $kelas = Kelas::find($kelasId);

            $jadwal = JadwalPelajaran::with(['mataPelajaran', 'guru'])
                ->where('kelas_id', $kelasId)
                ->get();

            foreach ($jadwal as $j) {
                for ($i = $j->jam_mulai; $i <= $j->jam_selesai; $i++) {
                    $jadwalByHari[$j->hari][$i] = $j;
                }
            }
        }

        $pdf = Pdf::loadView('exports.pdf', compact('jadwalByHari', 'kelas'))
                ->setPaper('A4', 'landscape');
        
        return $pdf->download('jadwal-pelajaran.pdf');
    }
    public function export()
    {
        return Excel::download(new JadwalPelajaranExport, 'jadwal_pelajaran.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls',
        ]);

        Excel::import(new JadwalPelajaranImport, $request->file('file'));

        return redirect()->route('admin.jadwal.index')->with('success', 'Data jadwal pelajaran berhasil diimport');
    }

    public function index(Request $request)
    {
        $kelasList = Kelas::all();
        $kelasId   = $request->get('kelas_id');

        $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat'];
        $jadwalByHari = [];

        foreach ($hariList as $hari) {
            $jadwalByHari[$hari] = [];
        }

        if ($kelasId) {
            $jadwal = JadwalPelajaran::with(['mataPelajaran', 'guru'])
                        ->where('kelas_id', $kelasId)
                        ->get();

            foreach ($jadwal as $j) {
                for ($i = $j->jam_mulai; $i <= $j->jam_selesai; $i++) {
                    $jadwalByHari[$j->hari][$i] = $j;
                }
            }
        }

        return view('pages.admin.jadwal.index', compact('kelasList', 'kelasId', 'jadwalByHari'));
    }

    public function edit($kelasId)
    {
        $kelas = Kelas::findOrFail($kelasId);
        $mapel = MataPelajaran::all();
        $guru  = Guru::all();

        $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat'];
        $jadwalByHari = [];
        foreach ($hariList as $hari) {
            $jadwalByHari[$hari] = [];
        }

        $jadwal = JadwalPelajaran::where('kelas_id', $kelasId)->get();
        foreach ($jadwal as $j) {
            for ($i = $j->jam_mulai; $i <= $j->jam_selesai; $i++) {
                $jadwalByHari[$j->hari][$i] = $j;
            }
        }

        return view('pages.admin.jadwal.edit', compact('kelas','mapel','guru','jadwalByHari'));
    }

    public function updateSchedule(Request $request, $kelasId)
    {
        $request->validate([
            'jadwal' => 'required|array',
        ]);

        $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat'];

        foreach ($hariList as $hari) {
            if (!isset($request->jadwal[$hari])) continue;

            foreach ($request->jadwal[$hari] as $jam => $data) {
                if (!empty($data['mapel_id'])) {
                    JadwalPelajaran::updateOrCreate(
                        [
                            'kelas_id'   => $kelasId,
                            'hari'       => $hari,
                            'jam_mulai'  => $jam,
                            'jam_selesai'=> $jam,
                        ],
                        [
                            'mata_pelajaran_id' => $data['mapel_id'],
                            'guru_id'           => $data['guru_id'] ?? null,
                        ]
                    );
                }
            }
        }

        return redirect()->route('admin.jadwal.index', ['kelas_id' => $kelasId])
                         ->with('success', 'Jadwal pelajaran berhasil diperbarui');
    }
}
