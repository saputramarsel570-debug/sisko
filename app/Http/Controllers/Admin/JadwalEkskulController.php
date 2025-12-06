<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalEkskul;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use App\Exports\JadwalEkskulExport;
use Maatwebsite\Excel\Facades\Excel;

class JadwalEkskulController extends Controller
{
    public function export()
    {
        return Excel::download(new JadwalEkskulExport, 'jadwal_ekskul.xlsx');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jadwal = JadwalEkskul::with('ekstrakurikuler')->get();
        return view('pages.admin.jadwal_ekskul.index', compact('jadwal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ekskul = Ekstrakurikuler::all();
        $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
        return view('pages.admin.jadwal_ekskul.create', compact('ekskul', 'hariList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ekstrakurikuler_id' => 'required|exists:ekstrakurikuler,id',
            'hari' => 'required|array|min:1',
            'hari.*' => 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
        ]);

        JadwalEkskul::create([
            'ekstrakurikuler_id' => $request->ekstrakurikuler_id,
            'hari' => $request->hari, 
        ]);

        return redirect()->route('admin.jadwal_ekskul.index')
            ->with('success', 'Jadwal ekskul berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JadwalEkskul $jadwal_ekskul)
    {
        $jadwal_ekskul->load('ekstrakurikuler');
        return view('pages.admin.jadwal_ekskul.show', compact('jadwal_ekskul'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JadwalEkskul $jadwal_ekskul)
    {
        $ekskul = Ekstrakurikuler::all();
        $hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
        return view('pages.admin.jadwal_ekskul.edit', compact('jadwal_ekskul', 'ekskul', 'hariList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JadwalEkskul $jadwal_ekskul)
    {
        $request->validate([
            'ekstrakurikuler_id' => 'required|exists:ekstrakurikuler,id',
            'hari' => 'required|array|min:1',
            'hari.*' => 'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
        ]);

        $jadwal_ekskul->update([
            'ekstrakurikuler_id' => $request->ekstrakurikuler_id,
            'hari' => $request->hari,
        ]);

        return redirect()->route('admin.jadwal_ekskul.index')
            ->with('success', 'Jadwal ekskul berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JadwalEkskul $jadwal_ekskul)
    {
        $jadwal_ekskul->delete();

        return redirect()->route('admin.jadwal_ekskul.index')
            ->with('success', 'Jadwal ekskul berhasil dihapus.');
    }
}
