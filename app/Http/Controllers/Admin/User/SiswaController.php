<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiswaOrangtuaImport;

class SiswaController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new SiswaOrangtuaImport, $request->file('file'));

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa & orangtua berhasil diimport');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kelasList = Kelas::all();
        $kelasId = $request->get('kelas_id');
        $role = $request->get('role');

        $siswa = Siswa::with(['user', 'kelas'])
            ->when($kelasId, function ($query) use ($kelasId) {
                $query->where('kelas_id', $kelasId);
            })
            ->when($role, function ($query) use ($role) {
                $query->whereHas('user', function ($q) use ($role) {
                    $q->where('role', $role);
                });
            })
            ->get();

        return view('pages.admin.users.siswa.index', compact('siswa', 'kelasList', 'kelasId', 'role'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelasList = Kelas::all();
        return view('pages.admin.users.siswa.create', compact('kelasList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:siswa,nis',
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'role' => 'required|in:siswa,siswa_perwakilan',
        ]);

        $user = User::create([
            'username' => $request->username,
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        Siswa::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'kelas_id' => $request->kelas_id,
            'user_id' => $user->id,
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        $siswa->load('user', 'kelas');
        return view('pages.admin.users.siswa.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        $kelasList = Kelas::all();
        $siswa->load('user');
        return view('pages.admin.users.siswa.edit', compact('siswa', 'kelasList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nis' => 'required|unique:siswa,nis,' . $siswa->id,
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'username' => 'required|string|max:255|unique:users,username,' . $siswa->user_id,
            'email' => 'required|email|unique:users,email,' . $siswa->user_id,
            'password' => 'nullable|confirmed|min:6',
            'role' => 'required|in:siswa,siswa_perwakilan',
        ]);

        $user = $siswa->user;
        $user->update([
            'username' => $request->username,
            'name' => $request->nama,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'role' => $request->role,
        ]);

        $siswa->update([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        if ($siswa->user) {
            $siswa->user()->delete();
        }
        $siswa->delete();

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus');
    }
}
