<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Jurnal;
use App\Models\JadwalPelajaran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JurnalController extends Controller
{
    public function index(Request $request)
    {
        $guru = auth()->user()->guru;

        $kelasId = $request->get('kelas_id');

        $query = Jurnal::with(['guru', 'kelas', 'mapel'])
            ->where('guru_id', $guru->id)
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_mulai');

        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }

        $jurnal = $query->paginate(10);

        return view('pages.guru.jurnal.index', compact('jurnal', 'kelasId'));
    }

    public function create(Request $request)
    {
        $guru = auth()->user()->guru;
        $kelasId = $request->get('kelas_id');
        $hariIni = Carbon::now()->locale('id')->isoFormat('dddd'); 

        $query = JadwalPelajaran::with(['kelas', 'mataPelajaran', 'guru'])
            ->where('guru_id', $guru->id)
            ->where('hari', $hariIni)
            ->orderBy('jam_mulai');

        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }

        $jadwals = $query->get();

        $jadwalDipilih = $jadwals->first(function ($j) use ($guru) {
            return !Jurnal::where('guru_id', $guru->id)
                ->where('kelas_id', $j->kelas_id)
                ->where('mapel_id', $j->mata_pelajaran_id)
                ->whereDate('tanggal', Carbon::today())
                ->where('jam_mulai', $j->jam_mulai)
                ->exists();
        });

        if (! $jadwalDipilih) {
            return redirect()->route('guru.jurnal.index', ['kelas_id' => $kelasId])
                ->with('error', 'Tidak ada jadwal kosong untuk dibuat jurnal hari ini.');
        }

        return view('pages.guru.jurnal.create', [
            'jadwal' => $jadwalDipilih,
            'hariIni' => $hariIni,
            'kelasId' => $kelasId,
        ]);
    }

    public function store(Request $request)
    {
        $guru = auth()->user()->guru;

        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mapel_id' => 'required|exists:mata_pelajaran,id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'materi' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $cek = Jurnal::where('guru_id', $guru->id)
            ->where('kelas_id', $request->kelas_id)
            ->where('mapel_id', $request->mapel_id)
            ->whereDate('tanggal', $request->tanggal)
            ->where('jam_mulai', $request->jam_mulai)
            ->exists();

        if ($cek) {
            return redirect()->route('guru.jurnal.index')
                ->with('error', 'Jurnal untuk jam ini sudah ada.');
        }

        Jurnal::create([
            'guru_id' => $guru->id,
            'kelas_id' => $request->kelas_id,
            'mapel_id' => $request->mapel_id,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'materi' => $request->materi,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('guru.jurnal.index')
            ->with('success', 'Jurnal berhasil dibuat.');
    }

    public function show(Jurnal $jurnal)
    {
        $this->authorize('view', $jurnal);
        return view('pages.guru.jurnal.show', compact('jurnal'));
    }

    public function edit(Jurnal $jurnal)
    {
        $this->authorize('update', $jurnal);
        return view('pages.guru.jurnal.edit', compact('jurnal'));
    }

    public function update(Request $request, Jurnal $jurnal)
    {
        $this->authorize('update', $jurnal);

        $request->validate([
            'materi' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $jurnal->update([
            'materi' => $request->materi,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('guru.jurnal.index')
            ->with('success', 'Jurnal berhasil diperbarui.');
    }
}