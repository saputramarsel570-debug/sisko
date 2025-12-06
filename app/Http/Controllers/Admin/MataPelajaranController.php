<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Imports\MapelImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MataPelajaranExport;
use App\Exports\MapelTemplateExport;

class MataPelajaranController extends Controller
{
    public function downloadTemplate()
    {
        return Excel::download(new MapelTemplateExport, 'template_mapel.xlsx');
    }

    public function export()
    {
        return Excel::download(new MataPelajaranExport, 'mata_pelajaran.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls',
        ]);

        $import = new MapelImport;
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
        $mapel = MataPelajaran::all();
        return view('pages.admin.mapel.index', compact('mapel'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.mapel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_mapel' => [
                'required',
                'string',
                'max:20',
                'regex:/^[A-Za-z0-9\-_]+$/',
                'unique:mata_pelajaran,kode_mapel',
            ],
            'nama_mapel' => [
                'required',
                'string',
                'max:255',
                Rule::unique('mata_pelajaran')->where(function ($q) use ($request) {
                    return $q->whereRaw('LOWER(nama_mapel) = ?', strtolower($request->nama_mapel));
                })
            ],
        ], [
            'kode_mapel.max' => 'Kode mapel maksimal 20 karakter.',
            'kode_mapel.regex' => 'Kode mapel hanya boleh huruf, angka, dash dan underscore.',
            'kode_mapel.unique' => 'Kode mapel sudah digunakan.',
            'nama_mapel.max' => 'Nama mata pelajaran maksimal 255 karakter.',
            'nama_mapel.unique' => 'Nama mata pelajaran sudah ada.',
        ]);

        MataPelajaran::create($request->only(['kode_mapel', 'nama_mapel']));

        return redirect()->route('admin.mapel.index')->with('success', 'Mata pelajaran berhasil ditambahkan');
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
    public function edit(MataPelajaran $mapel)
    {
        return view('pages.admin.mapel.edit', compact('mapel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MataPelajaran $mapel)
    {
        $request->validate([
            'kode_mapel' => [
                'required',
                'string',
                'max:20',
                'regex:/^[A-Za-z0-9\-_]+$/',
                Rule::unique('mata_pelajaran', 'kode_mapel')->ignore($mapel->id),
            ],
            'nama_mapel' => [
                'required',
                'string',
                'max:255',
                Rule::unique('mata_pelajaran')->ignore($mapel->id)
                    ->where(function ($q) use ($request) {
                        return $q->whereRaw('LOWER(nama_mapel) = ?', strtolower($request->nama_mapel));
                    }),
            ],
        ], [
            'kode_mapel.max' => 'Kode mapel maksimal 20 karakter.',
            'kode_mapel.regex' => 'Kode mapel hanya boleh huruf, angka, dash dan underscore.',
            'kode_mapel.unique' => 'Kode mapel sudah digunakan.',
            'nama_mapel.max' => 'Nama mata pelajaran maksimal 255 karakter.',
            'nama_mapel.unique' => 'Nama mata pelajaran sudah ada.',
        ]);

        $mapel->update($request->only(['kode_mapel', 'nama_mapel']));

        return redirect()->route('admin.mapel.index')->with('success', 'Mata pelajaran berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MataPelajaran $mapel)
    {
        $mapel->delete();
        return redirect()->route('admin.mapel.index')->with('success', 'Mata pelajaran berhasil dihapus');
    }
}
