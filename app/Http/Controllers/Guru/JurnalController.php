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
    $guruId = Auth::user()->guru->id;

    $jadwal = JadwalPelajaran::with(['kelas', 'mataPelajaran'])
        ->where('guru_id', $guruId)
        ->where('hari', Carbon::now()->isoFormat('dddd'))
        ->first();

    if (!$jadwal) {
        return redirect()->route('guru.jurnal.index')
            ->with('error', 'Tidak ada jadwal untuk hari ini.');
    }

    return view('pages.guru.jurnal.create', compact('jadwal'));
}

    public function store(Request $request)
{
    $request->validate([
        'materi'  => 'required|string',
        'catatan' => 'nullable|string',
    ]);

    $guruId = Auth::user()->guru->id;
    $tanggal = Carbon::now()->toDateString();

    $jadwal = JadwalPelajaran::with('mataPelajaran')
        ->where('guru_id', $guruId)
        ->where('hari', Carbon::now()->isoFormat('dddd'))
        ->first();

    if (!$jadwal) {
        return redirect()->route('guru.jurnal.index')
            ->with('error', 'Tidak ada jadwal untuk hari ini.');
    }

    Jurnal::create([
        'tanggal'  => $tanggal,
        'guru_id'  => $guruId,
        'kelas_id' => $jadwal->kelas_id,
        'mapel'    => optional($jadwal->mataPelajaran)->nama_mapel,
        'materi'   => $request->materi,
        'catatan'  => $request->catatan,
    ]);

    return redirect()->route('guru.jurnal.index')->with('success', 'Jurnal berhasil ditambahkan');
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