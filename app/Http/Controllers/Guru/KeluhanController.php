<?php

namespace App\Http\Controllers\Guru;

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

        return redirect()->route('guru.keluhan.index')
            ->with('success', 'Keluhan/Saran berhasil diperbarui');
    }
}