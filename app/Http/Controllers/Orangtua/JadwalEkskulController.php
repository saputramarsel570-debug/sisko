<?php

namespace App\Http\Controllers\Orangtua;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalEkskul;
use App\Models\Ekstrakurikuler;

class JadwalEkskulController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jadwal = JadwalEkskul::with('ekstrakurikuler')->get();
        return view('pages.orangtua.jadwal_ekskul.index', compact('jadwal'));
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
    public function show(JadwalEkskul $jadwal_ekskul)
    {
        $jadwal_ekskul->load('ekstrakurikuler');
        return view('pages.orangtua.jadwal_ekskul.show', compact('jadwal_ekskul'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
