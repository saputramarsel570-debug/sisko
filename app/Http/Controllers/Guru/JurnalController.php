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
    public function index()
    {
        $jurnal = Jurnal::with(['guru', 'kelas'])->latest()->get();
        return view('pages.guru.jurnal.index', compact('jurnal'));
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
                    ->first();

        if (!$jadwal) {
            return redirect()->route('guru.jurnal.index')->with('error', 'Anda belum memiliki jadwal pelajaran.');
        }

        return view('pages.guru.jurnal.create', compact('jadwal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_pelajaran,id',
            'materi'    => 'required|string',
            'catatan'   => 'nullable|string',
        ]);

        $guruId = Auth::user()->guru->id;
        $jadwal = JadwalPelajaran::with('mataPelajaran')->findOrFail($request->jadwal_id);

        if ($jadwal->guru_id != $guruId) {
            return redirect()->back()->withErrors('Jadwal tidak valid untuk akun Anda.');
        }

        $tanggal = Carbon::now()->toDateString();
        $mapelName = optional($jadwal->mataPelajaran)->nama_mapel ?? null;

        $exists = Jurnal::where('tanggal', $tanggal)
            ->where('guru_id', $guruId)
            ->where('kelas_id', $jadwal->kelas_id)
            ->where('mapel', $mapelName)
            ->exists();

        if ($exists) {
            return redirect()->route('guru.jurnal.create')->with('info', 'Jurnal untuk jadwal ini sudah dibuat hari ini.');
        }

        Jurnal::create([
            'tanggal'  => $tanggal,
            'guru_id'  => $guruId,
            'kelas_id' => $jadwal->kelas_id,
            'mapel'    => $mapelName,
            'materi'   => $request->materi,
            'catatan'  => $request->catatan,
        ]);

        return redirect()->route('guru.jurnal.create')->with('success', 'Jurnal berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jurnal = Jurnal::findOrFail($id);
        $jurnal->load(['kelas', 'guru']);
        return view('pages.guru.jurnal.edit', compact('jurnal'));
    }

    public function update(Request $request, $id)
    {
        $jurnal = Jurnal::findOrFail($id);

        $request->validate([
            'materi'   => 'required|string',
            'catatan'  => 'nullable|string',
        ]);

        $jurnal->update([
            'materi'  => $request->materi,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('guru.jurnal.index')->with('success', 'Jurnal berhasil diperbarui');
    }
}