<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Jurnal;
use App\Models\Kelas;
use App\Models\JadwalPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class JurnalController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal', Carbon::today()->toDateString());
        $kelasId = $request->input('kelas_id');

        $kelas = Kelas::orderBy('nama_kelas')->get();

        $query = Jurnal::with(['guru', 'kelas'])
            ->whereDate('tanggal', $tanggal)
            ->orderBy('created_at', 'desc');

        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }

        $jurnal = $query->get();

        return view('pages.guru.jurnal.index', compact('jurnal', 'tanggal', 'kelas', 'kelasId'));
    }

    public function show($id)
    {
        $jurnal = Jurnal::with(['guru', 'kelas'])->findOrFail($id);
        return view('pages.guru.jurnal.show', compact('jurnal'));
    }

    public function create()
    {
        $hariIni = Carbon::now()->locale('id')->dayName;
        $guruId = Auth::user()->guru->id;

        $jadwal = JadwalPelajaran::with(['kelas', 'mataPelajaran'])
            ->where('guru_id', $guruId)
            ->where('hari', $hariIni)
            ->first();

        return view('pages.guru.jurnal.create', compact('jadwal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'materi'  => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $guruId = Auth::user()->guru->id;
        $hariIni = Carbon::now()->locale('id')->dayName;

        $jadwal = JadwalPelajaran::where('guru_id', $guruId)
            ->where('hari', $hariIni)
            ->first();

        Jurnal::create([
            'tanggal' => Carbon::today()->toDateString(),
            'guru_id' => $guruId,
            'kelas_id' => $jadwal->kelas_id ?? null,
            'mapel' => $jadwal->mataPelajaran->nama_mapel ?? null,
            'materi' => $request->materi,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('guru.jurnal.index')
            ->with('success', 'Jurnal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jurnal = Jurnal::findOrFail($id);
        return view('pages.guru.jurnal.edit', compact('jurnal'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'materi'  => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $jurnal = Jurnal::findOrFail($id);
        $jurnal->update([
            'materi'  => $request->materi,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('guru.jurnal.index')
            ->with('success', 'Jurnal berhasil diperbarui.');
    }
}