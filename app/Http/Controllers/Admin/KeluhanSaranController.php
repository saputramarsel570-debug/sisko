<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KeluhanSaran;
use App\Models\User;
use Illuminate\Http\Request;

class KeluhanSaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $keluhanSaran = KeluhanSaran::with('user')->latest()->paginate(10);
        return view('pages.admin.keluhan_saran.index', compact('keluhanSaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(KeluhanSaran $keluhanSaran)
    {
        return view('pages.admin.keluhan_saran.show', compact('keluhanSaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KeluhanSaran $keluhanSaran)
    {
        return view('pages.admin.keluhan_saran.edit', compact('keluhanSaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KeluhanSaran $keluhanSaran)
    {
        $request->validate([
            'status'  => 'required|in:pending,proses,selesai',
            'balasan' => 'nullable|string',
        ]);

        $keluhanSaran->update($request->only(['status', 'balasan']));

        return redirect()->route('admin.keluhan_saran.index')->with('success', 'Keluhan/Saran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KeluhanSaran $keluhanSaran)
    {
        $keluhanSaran->delete();

        return redirect()->route('admin.keluhan_saran.index')->with('success', 'Keluhan/Saran berhasil dihapus.');
    }
}
