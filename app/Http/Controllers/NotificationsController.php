<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function read($id)
    {
        $user = auth()->user();
        $notification = $user->notifications()->findOrFail($id);
        $notification->markAsRead();

        switch ($user->role) {
            case 'siswa_perwakilan':
                return redirect()->route('siswa_perwakilan.keluhan.index');

            case 'siswa':
                return redirect()->route('siswa.keluhan.index');

            case 'guru':
                return redirect()->route('guru.keluhan.index');

            default:
                return redirect()->back()->with('info', 'Notifikasi dibaca.');
        }
    }
}