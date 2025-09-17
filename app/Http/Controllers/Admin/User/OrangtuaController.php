<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\OrangTua;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OrangtuaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kelasId = $request->get('kelas_id');
        $search = $request->get('search');

        $query = Orangtua::with('siswa.kelas', 'user');

        if ($kelasId) {
            $query->whereHas('siswa', function ($q) use ($kelasId) {
                $q->where('kelas_id', $kelasId);
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")->orWhereHas('siswa', function ($q2) use ($search) {
                    $q2->where('nama', 'like', "%$search%")->orWhere('nis', 'like', "%$search%");
                });
            });
        }

        $orangtua = $query->get();
        $kelas = Kelas::all();

        return view('pages.admin.users.orangtua.index', compact('orangtua', 'kelas', 'kelasId', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $siswa = Siswa::with('kelas')->get();
        return view('pages.admin.users.orangtua.create', compact('siswa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'username' => $request->username,
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'orangtua',
        ]);

        Orangtua::create([
            'user_id' => $user->id,
            'siswa_id' => $request->siswa_id,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('admin.orangtua.index')->with('success', 'Data orang tua berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Orangtua $orangtua)
    {
        $orangtua->load('siswa.kelas', 'user');
        return view('pages.admin.users.orangtua.show', compact('orangtua'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Orangtua $orangtua)
    {
        $siswa = Siswa::with('kelas')->get();
        return view('pages.admin.users.orangtua.edit', compact('orangtua', 'siswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Orangtua $orangtua)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email,' . $orangtua->user_id,
            'password' => 'nullable|confirmed|min:6',
        ]);

        $user = $orangtua->user;
        $user->update([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        $orangtua->update([
            'siswa_id' => $request->siswa_id,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
        ]);

        return redirect()->route('admin.orangtua.index')->with('success', 'Data orang tua berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Orangtua $orangtua)
    {
        $orangtua->user()->delete();
        $orangtua->delete();

        return redirect()->route('admin.orangtua.index')->with('success', 'Data orang tua berhasil dihapus');
    }
}
