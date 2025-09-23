<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Jurnal;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JurnalController extends Controller
{
    public function index()
    {
        $jurnal = Jurnal::with(['guru', 'kelas'])
            ->where('guru_id', Auth::user()->guru->id)
            ->latest()
            ->get();

        return view('pages.guru.jurnal.index', compact('jurnal'));
    }

    public function show($id)
    {
        $jurnal = Jurnal::findOrFail($id);
        return view('pages.guru.jurnal.show', compact('jurnal'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $mapel = MataPelajaran::all();
        $guru  = Guru::all();

        return view('pages.guru.jurnal.create', compact('kelas', 'mapel', 'guru'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'  => 'required|date',
            'kelas_id' => 'required|exists:kelas,id',
            'mapel'    => 'required|string',
            'materi'   => 'required|string',
            'catatan'  => 'nullable|string',
        ]);

        Jurnal::create([
            'tanggal'  => $request->tanggal,
            'guru_id'  => Auth::user()->guru->id,
            'kelas_id' => $request->kelas_id,
            'mapel'    => $request->mapel,
            'materi'   => $request->materi,
            'catatan'  => $request->catatan,
        ]);

        return redirect()->route('guru.jurnal.index')->with('success', 'Jurnal berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jurnal = Jurnal::findOrFail($id);
        $kelas  = Kelas::all();
        $mapel  = MataPelajaran::all();

        return view('pages.guru.jurnal.edit', compact('jurnal', 'kelas', 'mapel'));
    }

    public function update(Request $request, $id)
    {
        $jurnal = Jurnal::findOrFail($id);

        $request->validate([
            'tanggal'  => 'required|date',
            'kelas_id' => 'required|exists:kelas,id',
            'mapel'    => 'required|string',
            'materi'   => 'required|string',
            'catatan'  => 'nullable|string',
        ]);

        $jurnal->update([
            'tanggal'  => $request->tanggal,
            'kelas_id' => $request->kelas_id,
            'mapel'    => $request->mapel,
            'materi'   => $request->materi,
            'catatan'  => $request->catatan,
        ]);

        return redirect()->route('guru.jurnal.index')->with('success', 'Jurnal berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $jurnal = Jurnal::findOrFail($id);
        $jurnal->delete();
        return redirect()->route('guru.jurnal.index')
            ->with('success', 'Jurnal berhasil dihapus');
    }
}