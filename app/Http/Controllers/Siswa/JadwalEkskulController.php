<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\JadwalEkskul;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class JadwalEkskulController extends Controller
{
    public function index()
    {
        $jadwal = JadwalEkskul::with('ekstrakurikuler')->get();
        return view('pages.siswa.jadwal_ekskul.index', compact('jadwal'));
    }
}
