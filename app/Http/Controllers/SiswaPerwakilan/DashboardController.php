<?php

namespace App\Http\Controllers\SiswaPerwakilan;

use App\Http\Controllers\Controller;
use App\Models\JadwalPelajaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $jadwal = JadwalPelajaran::all();
        return view('pages.siswa-perwakilan.dashboard', compact('jadwal'));
    }
}
