<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Guru;
use Illuminate\Http\Request;
use App\Imports\KelasImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KelasExport;
use App\Exports\KelasTemplateExport;

class KelasController extends Controller
{
    public function template()
    {
        return Excel::download(new KelasTemplateExport, 'kelas_template.xlsx');
    }

    public function export()
    {
        return Excel::download(new KelasExport, 'kelas.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls',
        ]);

        $import = new KelasImport;
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
        $kelas = Kelas::with('waliKelas')->get();
        return view('pages.admin.kelas.index', compact('kelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $guru = Guru::all();
        return view('pages.admin.kelas.create', compact('guru'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-z0-9\s\.\-]+$/',
                'unique:kelas,nama_kelas',
            ],
            'wali_kelas_id' => 'nullable|exists:guru,id',
        ], [
            'nama_kelas.max' => 'Nama kelas maksimal 255 karakter.',
            'nama_kelas.regex' => 'Nama kelas hanya boleh huruf, angka, spasi, titik, dan tanda minus.',
            'nama_kelas.unique' => 'Nama kelas sudah digunakan.',
            'wali_kelas_id.exists' => 'Guru yang dipilih tidak valid.',
        ]);

        Kelas::create($request->only(['nama_kelas', 'wali_kelas_id']));

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelas $kelas)
    {
        $guru = Guru::all();
        return view('pages.admin.kelas.edit', [
            'kelas' => $kelas,
            'guru' => $guru,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelas $kelas)
    {
        $request->validate([
            'nama_kelas' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-z0-9\s\.\-]+$/',
                'unique:kelas,nama_kelas,' . $kelas->id,
            ],
            'wali_kelas_id' => 'nullable|exists:guru,id',
        ], [
            'nama_kelas.max' => 'Nama kelas maksimal 255 karakter.',
            'nama_kelas.regex' => 'Nama kelas hanya boleh huruf, angka, spasi, titik, dan tanda minus.',
            'nama_kelas.unique' => 'Nama kelas sudah digunakan.',
            'wali_kelas_id.exists' => 'Guru yang dipilih tidak valid.',
        ]);

        $kelas->update($request->only(['nama_kelas', 'wali_kelas_id']));

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelas $kelas)
    {
        foreach ($kelas->siswa as $siswa) {
            $siswa->update(['kelas_id' => null]);
        }
        $kelas->delete();
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus');
    }
}
