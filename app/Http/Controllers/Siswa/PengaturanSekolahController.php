<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\PengaturanSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanSekolahController extends Controller
{
    public function index()
    {
        $pengaturan = PengaturanSekolah::first(); 
        return view('pages.siswa.pengaturan.index', compact('pengaturan'));
    }
}
