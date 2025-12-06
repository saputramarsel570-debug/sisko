<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exports\EkstrakurikulerExport;
use Maatwebsite\Excel\Facades\Excel;

class EkstrakurikulerController extends Controller
{
    public function export()
    {
        return Excel::download(new EkstrakurikulerExport, 'ekstrakurikuler.xlsx');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ekskul = Ekstrakurikuler::all();
        return view('pages.admin.ekskul.index', compact('ekskul'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.ekskul.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:100',
            ],
            'deskripsi' => [
                'nullable',
                'string',
            ],
            'nama_pembina' => [
                'required',
                'string',
                'max:100',
            ],
            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ], [
            // Pesan Error Custom
            'nama.max' => 'Nama ekstrakurikuler maksimal 100 karakter.',
            'nama_pembina.max' => 'Nama pembina maksimal 100 karakter.',

            'foto.image' => 'File foto harus berupa gambar.',
            'foto.mimes' => 'Foto harus berformat JPG, JPEG, PNG, atau WebP.',
            'foto.max' => 'Ukuran maksimal foto adalah 2MB.',
        ]);

        $data = $validated;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('ekskul', 'public');
        }

        Ekstrakurikuler::create($data);

        return redirect()->route('admin.ekskul.index')
            ->with('success', 'Ekstrakurikuler berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ekstrakurikuler $ekskul)
    {
        return view('pages.admin.ekskul.show', compact('ekskul'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ekstrakurikuler $ekskul)
    {
        return view('pages.admin.ekskul.edit', compact('ekskul'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ekstrakurikuler $ekskul)
    {
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:100',
            ],
            'deskripsi' => [
                'nullable',
                'string',
            ],
            'nama_pembina' => [
                'required',
                'string',
                'max:100',
            ],
            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ], [
            // Pesan Error Custom
            'nama.max' => 'Nama ekstrakurikuler maksimal 100 karakter.',
            'nama_pembina.max' => 'Nama pembina maksimal 100 karakter.',

            'foto.image' => 'File foto harus berupa gambar.',
            'foto.mimes' => 'Foto harus berformat JPG, JPEG, PNG, atau WebP.',
            'foto.max' => 'Ukuran maksimal foto adalah 2MB.',
        ]);

        $data = $validated;

        if ($request->hasFile('foto')) {
            if ($ekskul->foto && Storage::disk('public')->exists($ekskul->foto)) {
                Storage::disk('public')->delete($ekskul->foto);
            }

            $data['foto'] = $request->file('foto')->store('ekskul', 'public');
        }

        $ekskul->update($data);

        return redirect()->route('admin.ekskul.index')
            ->with('success', 'Ekstrakurikuler berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ekstrakurikuler $ekskul)
    {
        if ($ekskul->foto && Storage::disk('public')->exists($ekskul->foto)) {
            Storage::disk('public')->delete($ekskul->foto);
        }

        $ekskul->delete();

        return redirect()->route('admin.ekskul.index')
            ->with('success', 'Ekstrakurikuler berhasil dihapus');
    }
}
