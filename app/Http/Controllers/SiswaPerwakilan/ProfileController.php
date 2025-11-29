<?php

namespace App\Http\Controllers\SiswaPerwakilan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('pages.siswa_perwakilan.profile.index', compact('user'));
    }

    /**
     * Update password siswa
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui');
    }

    /**
     * Update email siswa
     */
    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Email berhasil diperbarui');
    }

    /**
     * Update foto profil siswa
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        // Hapus foto lama jika ada
        if ($user->profile_photo && file_exists(public_path('uploads/profile/' . $user->profile_photo))) {
            unlink(public_path('uploads/profile/' . $user->profile_photo));
        }

        // Simpan foto baru
        $filename = time() . '.' . $request->profile_photo->extension();
        $request->profile_photo->move(public_path('uploads/profile'), $filename);

        $user->profile_photo = $filename;
        $user->save();

        return back()->with('success', 'Foto profil berhasil diperbarui');
    }
}