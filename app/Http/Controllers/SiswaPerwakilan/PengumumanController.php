<?php

namespace App\Http\Controllers\SiswaPerwakilan;

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
    $pengumuman = Pengumuman::whereIn('target', ['semua', 'siswa'])
                    ->latest()
                    ->get();

    $featured = $pengumuman->first(); 
    $others = $pengumuman->skip(1); 
     
    return view('pages.siswa_perwakilan.pengumuman.index', compact('featured', 'others'));
}

       public function show(string $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('pages.siswa_perwakilan.pengumuman.show', compact('pengumuman'));
    }
}
