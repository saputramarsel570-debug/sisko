<?php

namespace App\Http\Controllers\Siswa;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KeluhanSaran;

class KeluhanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $keluhan = KeluhanSaran::all();
        return view('pages.siswa.keluhan.index', compact('keluhan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.siswa.keluhan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string',
            'isi' => 'required|string',
        ]);

        KeluhanSaran::create([
            'user_id' => auth()->id(),
            'kategori' => $request->kategori,
            'isi' => $request->isi,
        ]);

        return redirect()->route('siswa.keluhan.index')
            ->with('success', 'Keluhan/Saran berhasil dikirim');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $keluhan = KeluhanSaran::findOrFail($id);
        return view('pages.siswa.keluhan.show', compact('keluhan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $keluhan = KeluhanSaran::findOrFail($id);
        return view('pages.siswa.keluhan.edit', compact('keluhan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori' => 'required|string',
            'isi' => 'required|string',
        ]);

        $keluhan = KeluhanSaran::findOrFail($id);
        $keluhan->update([
            'kategori' => $request->kategori,
            'isi' => $request->isi,
        ]);

        return redirect()->route('siswa.keluhan.index')
            ->with('success', 'Keluhan/Saran berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $keluhan = KeluhanSaran::findOrFail($id);
        $keluhan->delete();
        return redirect()->route('siswa.keluhan.index')
            ->with('success', 'Keluhan/Saran berhasil dihapus');
    }
}
