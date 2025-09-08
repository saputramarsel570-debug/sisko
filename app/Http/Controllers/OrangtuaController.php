<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrangtuaController extends Controller
{
    public function dashboard()
    {
        return view('pages.orangtua.dashboard');
    }

    public function absensi()
    {
        return view('pages.orangtua.absensi');
    }

    public function pengumuman()
    {
        return view('pages.orangtua.pengumuman');
    }
}
