<?php

namespace App\Http\Controllers\SiswaPerwakilan;

use App\Http\Controllers\Controller;
use App\Models\PengaturanSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanSekolahController extends Controller
{
    public function index()
    {
        $pengaturan = PengaturanSekolah::first(); 
        return view('pages.siswa_perwakilan.pengaturan.index', compact('pengaturan'));
    }
}
