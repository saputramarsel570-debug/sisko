<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengumuman;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengumuman = Pengumuman::with('user')->latest()->get();
        return view('pages.guru.pengumuman.index', compact('pengumuman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.guru.pengumuman.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'isi' => 'required|string',
        ]);

        Pengumuman::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'dibuat_oleh' => auth()->id(),
        ]);

        return redirect()->route('guru.pengumuman.index')
            ->with('success', 'Pengumuman Terbaru berhasil dikirim');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('pages.guru.pengumuman.show', compact('pengumuman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('pages.guru.pengumuman.edit', compact('pengumuman'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        Pengumuman::update([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'dibuat_oleh' => auth()->id(),
        ]);

        return redirect()->route('guru.pengumuman.index')
            ->with('success', 'Pengumuman berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Pengumuman::delete();
        return redirect()->route('guru.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus');
    }
}
