<?php

namespace App\Http\Controllers\SiswaPerwakilan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KeluhanSaran;
use App\Models\User;
use App\Notifications\KeluhanSaranNotification;

class KeluhanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $keluhan = KeluhanSaran::where('user_id', auth()->id())->get();
        return view('pages.siswa_perwakilan.keluhan.index', compact('keluhan'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.siswa_perwakilan.keluhan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'kategori' => 'required|in:keluhan,saran',
        'isi'      => 'required|string',
    ]);

    $keluhan =KeluhanSaran::create([
        'user_id'  => auth()->id(),
        'kategori' => $request->kategori,
        'isi'      => $request->isi,
    ]);

    $admins = User::where('role', 'admin')->get();

    foreach ($admins as $admin) {
        $admin->notify(new KeluhanSaranNotification(
            $request->kategori,
            auth()->user()->name,
            $request->isi,
            $keluhan->id
        ));
    }

    return redirect()->route('siswa_perwakilan.keluhan.index')
        ->with('success', 'Keluhan/Saran berhasil dikirim');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $keluhan = KeluhanSaran::where('user_id', auth()->id())->findOrFail($id);

        return view('pages.siswa_perwakilan.keluhan.show', compact('keluhan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $keluhan = KeluhanSaran::where('user_id', auth()->id())->findOrFail($id);

        return view('pages.siswa_perwakilan.keluhan.edit', compact('keluhan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori' => 'required|in:keluhan,saran',
            'isi' => 'required|string',
        ]);

        $keluhan = KeluhanSaran::where('user_id', auth()->id())->findOrFail($id);

        $keluhan->update([
            'kategori' => $request->kategori,
            'isi'      => $request->isi,
        ]);

        return redirect()->route('siswa_perwakilan.keluhan.index')
            ->with('success', 'Keluhan/Saran berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $keluhan = KeluhanSaran::where('user_id', auth()->id())->findOrFail($id);
        $keluhan->delete();

        return redirect()->route('siswa_perwakilan.keluhan.index')
            ->with('success', 'Keluhan/Saran berhasil dihapus');
    }
}