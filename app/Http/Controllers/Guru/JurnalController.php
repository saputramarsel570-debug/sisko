<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Jurnal;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\JadwalPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class JurnalController extends Controller
{
    public function index(Request $request)
    {
        $kelas = Kelas::all();
        $kelasId = $request->input('kelas_id');

        $jurnal = collect();
        if ($kelasId) {
            $jurnal = Jurnal::with(['guru', 'kelas'])
                ->where('kelas_id', $kelasId)
                ->latest()
                ->get();
        }

        return view('pages.guru.jurnal.index', compact('kelas', 'jurnal', 'kelasId'));
    }

    public function show($id)
    {
        $jurnal = Jurnal::with(['guru', 'kelas'])->findOrFail($id);
        return view('pages.guru.jurnal.show', compact('jurnal'));
    }

    public function create()
{
    $hariIni = \Carbon\Carbon::now()->isoFormat('dddd');

    $jadwal = \App\Models\JadwalPelajaran::where('guru_id', auth()->user()->id)
        ->where('hari', $hariIni)
        ->first();

    if ($jadwal) {
        $kelas = $jadwal->kelas->nama_kelas ?? '-';
        $mapel = $jadwal->mapel->nama_mapel ?? '-';
    } else {
        $kelas = 'Tidak ada jadwal hari ini';
        $mapel = 'Tidak ada mata pelajaran';
    }

    return view('pages.guru.jurnal.create', compact('kelas', 'mapel'));
}
public function store(Request $request)
{
    $hariIni = \Carbon\Carbon::now()->isoFormat('dddd');

    $jadwal = \App\Models\JadwalPelajaran::where('guru_id', auth()->user()->id)
        ->where('hari', $hariIni)
        ->first();

    $jurnal = new \App\Models\Jurnal();
    $jurnal->guru_id = auth()->user()->id;
    $jurnal->materi = $request->materi;
    $jurnal->catatan = $request->catatan;

    if ($jadwal) {
        $jurnal->kelas_id = $jadwal->kelas_id;
        $jurnal->mapel_id = $jadwal->mapel_id;
    } else {
        $jurnal->kelas_id = null;
        $jurnal->mapel_id = null;
    }

    $jurnal->save();

    return redirect()->route('guru.jurnal.index')
        ->with('success', 'Jurnal berhasil ditambahkan.');
}

    public function edit($id)
    {
        $jurnal = Jurnal::with(['kelas', 'guru'])->findOrFail($id);
        return view('pages.guru.jurnal.edit', compact('jurnal'));
    }

    public function update(Request $request, $id)
    {
        $jurnal = Jurnal::findOrFail($id);

        $request->validate([
            'materi'   => 'required|string',
            'catatan'  => 'nullable|string',
        ]);

        // Guru pembuat tidak diubah, hanya materi & catatan
        $jurnal->update([
            'materi'  => $request->materi,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('guru.jurnal.index')
            ->with('success', 'Jurnal berhasil diperbarui');
    }

    // Tidak ada destroy
}