<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GuruImport;

class GuruController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls',
        ]);

        Excel::import(new GuruImport, $request->file('file'));

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diimport');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guru = Guru::with('user')->get();
        return view('pages.admin.users.guru.index', compact('guru'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.users.guru.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:guru,nip',
            'nama' => 'required|string|max:255',
            'mapel' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'username' => $request->username,
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru',
        ]);

        Guru::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'mapel' => $request->mapel,
            'user_id' => $user->id,
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(Guru $guru)
    {
        $guru->load('user');
        return view('pages.admin.users.guru.show', compact('guru'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guru $guru)
    {
        return view('pages.admin.users.guru.edit', compact('guru'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nip' => 'required|unique:guru,nip,' . $guru->id,
            'nama' => 'required|string|max:255',
            'mapel' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $guru->user_id,
            'email' => 'required|email|unique:users,email,' . $guru->user_id,
            'password' => 'nullable|confirmed|min:6',
        ]);

        $user = $guru->user;
        $user->update([
            'username' => $request->username,
            'name' => $request->nama,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        $guru->update([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'mapel' => $request->mapel,
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diperbarui');
    }



    /**
     * Remove the specified resource from storage.
     */
     public function destroy(Guru $guru)
    {
        $guru->user()->delete();
        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil dihapus');
    }
}
