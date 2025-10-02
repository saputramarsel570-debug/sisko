<?php

namespace App\Http\Controllers\Orangtua;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orangtua = $user->orangtua;

        return view('pages.orangtua.dashboard.index', compact('user', 'orangtua'));
    }
}