<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KeluhanSaran;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class KeluhanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = KeluhanSaran::query()->with('user')->latest();

    // Filter kategori
    if ($request->filled('kategori')) {
        $query->where('kategori', $request->kategori);
    }

    // Filter status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // 🔍 Filter pencarian nama siswa/orangtua
    if ($request->filled('search')) {
        $search = $request->search;
    
        $query->where(function ($q) use ($search) {
            $q->whereHas('user', function ($user) use ($search) {
                $user->where('name', 'like', "%{$search}%");
            })
            ->orWhere('isi', 'like', "%{$search}%");
        });
    }

    $keluhan = $query->get();

    return view('pages.guru.keluhan.index', compact('keluhan'));
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $keluhan = KeluhanSaran::findOrFail($id);
        return view('pages.guru.keluhan.show', compact('keluhan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $keluhan = KeluhanSaran::findOrFail($id);
        return view('pages.guru.keluhan.edit', compact('keluhan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status'  => 'required|in:pending,proses,selesai',
            'balasan' => 'nullable|string',
        ]);

        $keluhan = KeluhanSaran::findOrFail($id);
        $keluhan->update([
            'status'  => $request->status,
            'balasan' => $request->balasan,
        ]);

        // 🔹 Kirim notifikasi ke user kalau dibalas
        if ($request->filled('balasan') && $keluhan->user) {
            $keluhan->user->notify(new \App\Notifications\BalasanKeluhanNotification($keluhan));
        }

        return redirect()->route('guru.keluhan.index')
        ->with('success', 'Keluhan/Saran berhasil diperbarui');
    }
    
    public function destroy(string $id)
    {
        $keluhan = KeluhanSaran::findOrFail($id);

        if ($keluhan->gambar && Storage::disk('public')->exists($keluhan->gambar)) {
            Storage::disk('public')->delete($keluhan->gambar);
        }

        $keluhan->delete();

        return redirect()->route('guru.keluhan.index')
            ->with('success', 'Keluhan berhasil dihapus');
    }
}