<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function read($id)
{
    $user = auth()->user();

    // Ambil unread dulu, kalau tidak ada baru ambil semua
    $notification = $user->unreadNotifications()->find($id)
                    ?? $user->notifications()->findOrFail($id);

    $notification->markAsRead();

    // Ambil tipe atau URL dari notifikasi
    $url  = $notification->data['url']  ?? null;
    $tipe = $notification->data['tipe'] ?? null;

    // Jika notifikasi punya URL langsung arahkan
    if ($url) {
        return redirect($url);
    }

    // Redirect berdasarkan role user
    switch ($user->role) {

        case 'siswa_perwakilan':
            return redirect()->route('siswa_perwakilan.keluhan.index');

        case 'siswa':
            return redirect()->route('siswa.keluhan.index');

        case 'guru':
            return redirect()->route('guru.keluhan.index');

        case 'orangtua':
            return redirect()->route('orangtua.keluhan.index');

        case 'admin':
            return redirect()->route('admin.keluhan_saran.index');
    }

    return back()->with('info', 'Notifikasi dibaca.');
}

}