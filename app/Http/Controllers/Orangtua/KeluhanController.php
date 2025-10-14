<?php

namespace App\Http\Controllers\Orangtua;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KeluhanSaran;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class KeluhanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = KeluhanSaran::where('user_id', auth()->id());

    // ✅ Filter kategori (Keluhan / Saran)
    if ($request->filled('kategori')) {
        $query->where('kategori', $request->kategori);
    }

    // ✅ Filter status (pending / proses / selesai)
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // ✅ Urutkan dari yang terbaru
    $keluhan = $query->orderByDesc('created_at')->get();

    return view('pages.orangtua.keluhan.index', compact('keluhan'));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.orangtua.keluhan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|in:keluhan,saran',
            'isi'      => 'required|string',
            'gambar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gambarPath = null;

        // Simpan gambar jika diunggah
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('keluhan', 'public');
        }

        $keluhan = KeluhanSaran::create([
            'user_id'  => auth()->id(),
            'kategori' => $request->kategori,
            'isi'      => $request->isi,
            'status'   => 'pending',
            'gambar'   => $gambarPath,
        ]);

        $gurus = User::where('role', 'guru')->get();
        foreach ($gurus as $guru) {
            $guru->notify(new \App\Notifications\KeluhanBaruNotification($keluhan));
        }

        return redirect()->route('orangtua.keluhan.index')
            ->with('success', 'Keluhan atau Saran berhasil dikirim');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $keluhan = KeluhanSaran::where('user_id', auth()->id())->findOrFail($id);
        return view('pages.orangtua.keluhan.show', compact('keluhan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $keluhan = KeluhanSaran::where('user_id', auth()->id())->findOrFail($id);
        return view('pages.orangtua.keluhan.edit', compact('keluhan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $request->validate([
        'kategori' => 'required|in:keluhan,saran',
        'isi'      => 'required|string',
        'gambar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $keluhan = KeluhanSaran::where('user_id', auth()->id())->findOrFail($id);

    $gambarPath = $keluhan->gambar; // default: pakai gambar lama

    // Jika ada gambar baru
    if ($request->hasFile('gambar')) {
        // Hapus gambar lama
        if ($gambarPath && Storage::disk('public')->exists($gambarPath)) {
            Storage::disk('public')->delete($gambarPath);
        }

        // Simpan gambar baru
        $gambarPath = $request->file('gambar')->store('keluhan_saran', 'public');
    }

    $keluhan->update([
        'kategori' => $request->kategori,
        'isi'      => $request->isi,
        'gambar'   => $gambarPath,
    ]);

    return redirect()->route('orangtua.keluhan.index')
        ->with('success', 'Keluhan/Saran berhasil diperbarui');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $keluhan = KeluhanSaran::where('user_id', auth()->id())->findOrFail($id);

        // Hapus gambar dari storage jika ada
        if ($keluhan->gambar && Storage::disk('public')->exists($keluhan->gambar)) {
            Storage::disk('public')->delete($keluhan->gambar);
        }

        $keluhan->delete();

        return redirect()->route('orangtua.keluhan.index')
            ->with('success', 'Keluhan/Saran berhasil dihapus');
    }
}