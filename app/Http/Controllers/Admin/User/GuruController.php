<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GuruImport;
use App\Exports\GuruExport;
use App\Exports\GuruTemplateExport;

class GuruController extends Controller
{
    public function template()
    {
        return Excel::download(new GuruTemplateExport, 'template_import_guru.xlsx');
    }

    public function export()
    {
        return Excel::download(new GuruExport, 'guru.xlsx');
    }

    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,csv,xls',
    ]);

    $import = new GuruImport;
    Excel::import($import, $request->file('file'));

    $successCount = $import->inserted;
    $failures = $import->failures();

    if ($successCount == 0 && $failures->isNotEmpty()) {
        return back()->with([
            'import_errors' => $failures,
            'import_failed_message' => 'Tidak ada data yang berhasil diimport.'
        ]);
    }

    if ($successCount > 0 && $failures->isNotEmpty()) {
        return back()->with([
            'import_success' => $successCount,
            'import_errors' => $failures,
        ]);
    }

    return back()->with('import_success', $successCount);
}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guru = Guru::with(['user', 'mataPelajaran'])->get();
        return view('pages.admin.users.guru.index', compact('guru'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mataPelajaran = MataPelajaran::all();
        return view('pages.admin.users.guru.create', compact('mataPelajaran'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => [
                'nullable',
                'digits_between:5,25',
                'numeric',
                'unique:guru,nip',
            ],
        
            'nama' => [
                'required',
                'string',
                'max:255',
            ],
        
            'mata_pelajaran_id' => 'nullable|exists:mata_pelajaran,id',
        
            'username' => [
                'required',
                'lowercase',
                'min:4',
                'max:50',
                'unique:users,username',
                'regex:/^[a-z0-9_]+$/',
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
            'nip.numeric' => 'NIP hanya boleh berisi angka.',
            'nip.digits_between' => 'NIP harus angka antara 5-25 digit.',
            'nip.unique' => 'NIP sudah terdaftar.',
            'nama.max' => 'Nama guru maksimal 255 karakter.',
            'username.lowercase' => 'Username hanya boleh huruf kecil.',
            'username.min' => 'Username minimal 4 karakter.',
            'username.max' => 'Username maksimal 50 karakter.',
            'username.unique' => 'Username sudah terdaftar.',
            'username.regex' => 'Username hanya boleh huruf kecil, angka, dan underscore.',
            'email.lowercase' => 'Email hanya boleh huruf kecil.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'email.regex' => 'Format email tidak valid.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.regex' => 'Password tidak boleh mengandung spasi.',
        ]);

        $user = User::create([
            'username' => strtolower($request->username),
            'name'     => $request->nama,
            'email'    => strtolower($request->email),
            'password' => Hash::make($request->password),
            'role'     => 'guru',
        ]);

        Guru::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'user_id' => $user->id,
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Guru $guru)
    {
        $guru->load(['user', 'mataPelajaran']);
        return view('pages.admin.users.guru.show', compact('guru'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guru $guru)
    {
        $mataPelajaran = MataPelajaran::all();
        return view('pages.admin.users.guru.edit', compact('guru', 'mataPelajaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'nip' => [
                'nullable',
                'digits_between:5,25',
                'numeric',
                'unique:guru,nip,' . $guru->id,
            ],
        
            'nama' => [
                'required',
                'string',
                'max:255',
            ],
        
            'mata_pelajaran_id' => [
                'nullable',
                'exists:mata_pelajaran,id',
            ],
        
            'username' => [
                'required',
                'lowercase',
                'min:4',
                'max:50',
                'unique:users,username,' . $guru->user_id,
                'regex:/^[a-z0-9_]+$/',
            ],
        
            'email' => [
                'required',
                'lowercase',
                'email',
                'unique:users,email,' . $guru->user_id,
                'regex:/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/',
            ],
        
            'password' => [
                'nullable',
                'min:6',
                'confirmed',
                'regex:/^\S+$/',
            ],
        ], [
            'nip.numeric' => 'NIP hanya boleh berisi angka.',
            'nip.digits_between' => 'NIP harus angka antara 5-25 digit.',
            'nip.unique' => 'NIP sudah terdaftar.',
            'nama.max' => 'Nama guru maksimal 255 karakter.',
            'username.lowercase' => 'Username hanya boleh huruf kecil.',
            'username.min' => 'Username minimal 4 karakter.',
            'username.max' => 'Username maksimal 50 karakter.',
            'username.unique' => 'Username sudah terdaftar.',
            'username.regex' => 'Username hanya boleh huruf kecil, angka, dan underscore.',
            'email.lowercase' => 'Email hanya boleh huruf kecil.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'email.regex' => 'Format email tidak valid.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.regex' => 'Password tidak boleh mengandung spasi.',
        ]);

        $user = $guru->user;

        $user->update([
            'username' => strtolower($request->username),
            'name' => $request->nama,
            'email' => strtolower($request->email),
            'password' => $request->filled('password')
                            ? Hash::make($request->password)
                            : $user->password,
        ]);

        $guru->update([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
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
