<?php

namespace App\Http\Controllers\Siswa;

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
        $pengumuman = Pengumuman::all();
        return view('pages.siswa.pengumuman.index', compact('pengumuman'));
    }

       public function show(string $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('pages.siswa.pengumuman.show', compact('pengumuman'));
    }
}
