<?php

namespace App\Http\Controllers\Admin\User;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function export()
    {
        return Excel::download(new UserExport, 'users.xlsx');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('pages.admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => [
                'required',
                'lowercase',
                'min:4',
                'max:50',
                'unique:users,username',
                'regex:/^[a-z0-9_]+$/', 
            ],
        
            'name' => [
                'required',
                'string',
                'max:255',
            ],
        
            'email' => [
                'required',
                'lowercase',
                'email',
                'unique:users,email',
                'regex:/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/',
            ],
        
            'password' => [
                'required',
                'min:6',
                'confirmed',
                'regex:/^\S+$/', 
            ],
        ], [
            'username.lowercase' => 'Username harus menggunakan huruf kecil.',
            'username.min' => 'Username minimal 4 karakter.',
            'username.max' => 'Username maksimal 50 karakter.',
            'username.unique' => 'Username sudah ada di database.',
            'username.regex' => 'Username hanya boleh huruf kecil, angka, dan underscore.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'email.lowercase' => 'Email harus menggunakan huruf kecil.',
            'email.regex' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah ada di database.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.regex' => 'Password tidak boleh mengandung spasi.',
        ]);

        User::create([
            'username' => strtolower($request->username),
            'name'     => $request->name,
            'email'    => strtolower($request->email),
            'role'     => 'admin',
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('pages.admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('pages.admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => [
                'required',
                'lowercase',
                'min:4',
                'max:50',
                'unique:users,username,' . $user->id,
                'regex:/^[a-z0-9_]+$/',
            ],
        
            'name' => [
                'required',
                'string',
                'max:255',
            ],
        
            'email' => [
                'required',
                'lowercase',
                'email',
                'unique:users,email,' . $user->id,
                'regex:/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/',
            ],
        
            'role' => [
                'required',
                'in:admin,guru,siswa,orangtua,siswa_perwakilan',
            ],
        
            'password' => [
                'nullable',
                'min:6',
                'confirmed',
                'regex:/^\S+$/',
            ],
        ], [
            'username.lowercase' => 'Username harus menggunakan huruf kecil.',
            'username.min' => 'Username minimal 4 karakter.',
            'username.max' => 'Username maksimal 50 karakter.',
            'username.unique' => 'Username sudah ada di database.',
            'username.regex' => 'Username hanya boleh huruf kecil, angka, dan underscore.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'email.lowercase' => 'Email harus menggunakan huruf kecil.',
            'email.regex' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah ada di database.',
            'role.in' => 'Role tidak valid.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.regex' => 'Password tidak boleh mengandung spasi.',
        ]);

        $user->update([
            'username' => strtolower($request->username),
            'name'     => $request->name,
            'email'    => strtolower($request->email),
            'role'     => $request->role,
            'password' => $request->filled('password')
                            ? Hash::make($request->password)
                            : $user->password,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus');
    }
}
