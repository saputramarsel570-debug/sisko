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
use App\Exports\SiswaOrtuExport;
use App\Exports\SiswaOrangtuaTemplateExport;

class SiswaController extends Controller
{
    public function template()
    {
        return Excel::download(new SiswaOrangtuaTemplateExport, 'template_import_siswa_ortu.xlsx');
    }

    public function export()
    {
        return Excel::download(new SiswaOrtuExport, 'siswa_ortu.xlsx');
    }

    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,csv,xls',
    ]);

    $import = new SiswaOrangtuaImport;
    Excel::import($import, $request->file('file'));

    $successCount = $import->inserted;
    $failures = $import->failures();

    // Jika tidak ada data sukses, tapi ada error
    if ($successCount == 0 && $failures->isNotEmpty()) {
        return back()->with([
            'import_errors' => $failures,
            'import_failed_message' => 'Tidak ada data yang berhasil diimport.'
        ]);
    }

    // Jika ada yg sukses dan ada error
    if ($successCount > 0 && $failures->isNotEmpty()) {
        return back()->with([
            'import_success' => $successCount,
            'import_errors' => $failures,
        ]);
    }

    // Semua berhasil
    return back()->with('import_success', $successCount);
}

public function resetAllPasswords()
{
    // Password baru disamakan untuk semua siswa
    $newPassword = Hash::make('disabled123');

    // Update semua user siswa
    User::where('role', 'siswa')->update([
        'password' => $newPassword,
    ]);

    return redirect()->back()->with('success', 'Semua password siswa berhasil direset!');
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
            'nis' => 'required|digits_between:5,25|unique:siswa,nis',
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
        
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
        
            'role' => 'required|in:siswa,siswa_perwakilan',
        
        ], [
            // NIS
            'nis.required' => 'NIS wajib diisi.',
            'nis.digits_between' => 'NIS harus 5-25 digit angka.',
            'nis.unique' => 'NIS sudah digunakan.',
        
            // Siswa
            'nama.required' => 'Nama siswa wajib diisi.',
            'nama.max' => 'Nama siswa maksimal 255 karakter.',
        
            'kelas_id.required' => 'Kelas wajib dipilih.',
            'kelas_id.exists' => 'Kelas tidak valid.',
        
            // Username
            'username.required' => 'Username siswa wajib diisi.',
            'username.min' => 'Username minimal 4 karakter.',
            'username.max' => 'Username maksimal 50 karakter.',
            'username.unique' => 'Username sudah digunakan.',
            'username.regex' => 'Username hanya boleh huruf kecil, angka, dan underscore.',
        
            // Email
            'email.required' => 'Email siswa wajib diisi.',
            'email.email' => 'Format email siswa tidak valid.',
            'email.unique' => 'Email siswa sudah digunakan.',
        
            // Password
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.regex' => 'Password tidak boleh mengandung spasi.',
        
            // Role
            'role.required' => 'Role siswa wajib dipilih.',
            'role.in' => 'Role siswa tidak valid.',
        ]);

        $user = User::create([
            'username' => strtolower($request->username),
            'name' => $request->nama,
            'email' => strtolower($request->email),
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
            'nis' => 'required|digits_between:5,25|unique:siswa,nis,' . $siswa->id,
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
        
            'username' => [
                'required',
                'min:4',
                'max:50',
                'unique:users,username,' . $siswa->user_id,
                'regex:/^[a-z0-9_]+$/'
            ],
        
            'email' => [
                'required',
                'email',
                'unique:users,email,' . $siswa->user_id,
            ],
        
            'password' => [
                'nullable',
                'min:6',
                'confirmed',
                'regex:/^\S+$/'
            ],
        
            'role' => 'required|in:siswa,siswa_perwakilan',
        
        ], [
        
            // NIS
            'nis.required' => 'NIS wajib diisi.',
            'nis.digits_between' => 'NIS harus 5–25 digit angka.',
            'nis.unique' => 'NIS sudah digunakan.',
        
            // Siswa
            'nama.required' => 'Nama siswa wajib diisi.',
            'nama.max' => 'Nama siswa maksimal 255 karakter.',
        
            'kelas_id.required' => 'Kelas wajib dipilih.',
            'kelas_id.exists' => 'Kelas tidak valid.',
        
            // Username
            'username.required' => 'Username siswa wajib diisi.',
            'username.min' => 'Username minimal 4 karakter.',
            'username.max' => 'Username maksimal 50 karakter.',
            'username.unique' => 'Username sudah digunakan.',
            'username.regex' => 'Username hanya boleh huruf kecil, angka, dan underscore.',
        
            // Email
            'email.required' => 'Email siswa wajib diisi.',
            'email.email' => 'Format email siswa tidak valid.',
            'email.unique' => 'Email siswa sudah digunakan.',
        
            // Password update
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.regex' => 'Password tidak boleh mengandung spasi.',
        
            // Role
            'role.required' => 'Role siswa wajib dipilih.',
            'role.in' => 'Role siswa tidak valid.',
        ]);

        $user = $siswa->user;

        $user->update([
            'username' => strtolower($request->username),
            'name' => $request->nama,
            'email' => strtolower($request->email),
            'password' => $request->filled('password')
                ? Hash::make($request->password)
                : $user->password,
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
