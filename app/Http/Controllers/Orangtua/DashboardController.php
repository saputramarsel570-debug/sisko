<?php

namespace App\Http\Controllers\Orangtua;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Guru;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orangtua = $user->orangtua;

        $gurus = Guru::with('mataPelajaran')->get();

        return view('pages.orangtua.dashboard.index', compact('user', 'orangtua', 'gurus'));
    }
}