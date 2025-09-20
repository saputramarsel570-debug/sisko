<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanSekolahController extends Controller
{
    public function index()
    {
        $pengaturan = PengaturanSekolah::first(); 
        return view('pages.admin.pengaturan.index', compact('pengaturan'));
    }

    public function edit($id)
    {
        $pengaturan = PengaturanSekolah::findOrFail($id);
        return view('pages.admin.pengaturan.edit', compact('pengaturan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'npsn' => 'nullable|string|max:50',
            'jenjang' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'kepala_sekolah' => 'nullable|string|max:255',
            'nip_kepala_sekolah' => 'nullable|string|max:50',
            'tahun_ajaran' => 'nullable|string|max:20',
            'semester' => 'nullable|string|max:20',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'kop_surat' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'ttd_kepsek' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $pengaturan = PengaturanSekolah::findOrFail($id);

        $data = $request->only([
            'nama_sekolah','npsn','jenjang','alamat','telepon','email',
            'kepala_sekolah','nip_kepala_sekolah','tahun_ajaran','semester'
        ]);

        foreach (['logo','kop_surat','ttd_kepsek'] as $field) {
            if ($request->hasFile($field)) {
                if ($pengaturan->$field) {
                    Storage::delete('public/'.$pengaturan->$field);
                }
                $data[$field] = $request->file($field)->store('pengaturan', 'public');
            }
        }

        $pengaturan->update($data);

        return redirect()->route('admin.pengaturan.index')->with('success', 'Pengaturan sekolah berhasil diperbarui');
    }
}
