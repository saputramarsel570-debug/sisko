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
    public function resetAllPasswords()
{
    $newPassword = Hash::make('disabled123');

    User::where('role', 'orangtua')->update([
        'password' => $newPassword,
    ]);

    return redirect()->back()->with('success', 'Semua password orang tua berhasil direset!');
}

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
        
            'no_hp' => [
                'required',
                'string',
                'digits_between:8,20',
                'regex:/^[0-9]+$/'
            ],
        
            'username' => [
                'required',
                'min:4',
                'max:50',
                'unique:users,username',
                'regex:/^[a-z0-9_]+$/'
            ],
        
            'email' => [
                'required',
                'email',
                'unique:users,email',
            ],
        
            'password' => [
                'required',
                'min:6',
                'confirmed',
                'regex:/^\S+$/'
            ],
        
        ], [
            'siswa_id.required' => 'Siswa wajib dipilih.',
            'siswa_id.exists' => 'Siswa tidak valid.',
        
            'nama.required' => 'Nama orang tua wajib diisi.',
        
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.digits_between' => 'Nomor HP harus 8-20 digit.',
            'no_hp.regex' => 'Nomor HP hanya boleh angka.',
        
            'username.required' => 'Username orang tua wajib diisi.',
            'username.min' => 'Username minimal 4 karakter.',
            'username.max' => 'Username maksimal 50 karakter.',
            'username.unique' => 'Username sudah digunakan.',
            'username.regex' => 'Username hanya boleh huruf kecil, angka, dan underscore.',
        
            'email.required' => 'Email orang tua wajib diisi.',
            'email.email' => 'Format email orang tua tidak valid.',
            'email.unique' => 'Email orang tua sudah digunakan.',
        
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.regex' => 'Password tidak boleh mengandung spasi.',
        ]);

        $user = User::create([
            'username' => strtolower($request->username),
            'name' => $request->nama,
            'email' => strtolower($request->email),
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
        
            'no_hp' => [
                'required',
                'digits_between:8,20',
                'regex:/^[0-9]+$/'
            ],
        
            'username' => [
                'required',
                'min:4',
                'max:50',
                'unique:users,username,' . $orangtua->user_id,
                'regex:/^[a-z0-9_]+$/'
            ],
        
            'email' => [
                'required',
                'email',
                'unique:users,email,' . $orangtua->user_id,
            ],
        
            'password' => [
                'nullable',
                'min:6',
                'confirmed',
                'regex:/^\S+$/'
            ],
        
        ], [
            'siswa_id.required' => 'Siswa wajib dipilih.',
            'siswa_id.exists' => 'Siswa tidak valid.',
        
            'nama.required' => 'Nama orang tua wajib diisi.',
        
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.digits_between' => 'Nomor HP harus 8–20 digit.',
            'no_hp.regex' => 'Nomor HP hanya boleh angka.',
        
            'username.required' => 'Username orang tua wajib diisi.',
            'username.min' => 'Username minimal 4 karakter.',
            'username.max' => 'Username maksimal 50 karakter.',
            'username.unique' => 'Username sudah digunakan.',
            'username.regex' => 'Username hanya boleh huruf kecil, angka, dan underscore.',
        
            'email.required' => 'Email orang tua wajib diisi.',
            'email.email' => 'Format email orang tua tidak valid.',
            'email.unique' => 'Email orang tua sudah digunakan.',
        
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.regex' => 'Password tidak boleh mengandung spasi.',
        ]);

        $user = $orangtua->user;

        $user->update([
            'username' => strtolower($request->username),
            'name' => $request->nama,
            'email' => strtolower($request->email),
            'password' => $request->filled('password')
                            ? Hash::make($request->password)
                            : $user->password,
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
