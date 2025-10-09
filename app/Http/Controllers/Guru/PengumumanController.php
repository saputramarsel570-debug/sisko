<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengumuman;
use App\Models\User;

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
        $validated = $request->validate([
            'judul'  => 'required|string|max:255',
            'isi'    => 'required|string',
            'target' => 'required|in:siswa,orangtua,semua',
        ]);

        $validated['dibuat_oleh'] = auth()->id();

        $pengumuman = Pengumuman::create($validated);
        $targetUsers = collect();

        if ($validated['target'] === 'siswa') {
            $targetUsers = User::whereIn('role', ['siswa', 'siswa_perwakilan', 'orangtua'])->get();
        } elseif ($validated['target'] === 'orangtua') {
            $targetUsers = User::where('role', 'orangtua')->get();
        } else { 
            $targetUsers = User::whereIn('role', ['siswa', 'siswa_perwakilan', 'orangtua'])->get();
        }

        foreach ($targetUsers as $user) {
            $user->notify(new \App\Notifications\PengumumanBaruNotification(
                $pengumuman->judul,
                $pengumuman->isi,
                $pengumuman->id
            ));
        }

        return redirect()
            ->route('guru.pengumuman.index')
            ->with('success', 'Pengumuman terbaru berhasil dikirim');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('pages.guru.pengumuman.show', compact('pengumuman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
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

        Pengumuman::findOrFail($id)->update([
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
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->delete();
        return redirect()->route('guru.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus');
    }
}
