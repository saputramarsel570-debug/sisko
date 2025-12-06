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
            'npsn' => 'nullable|digits:8',
            'jenjang' => 'nullable|string|max:50',
            'alamat' => 'nullable|string|max:255',
            'telepon' => ['nullable', 'regex:/^[0-9+\-\s]+$/', 'max:20'],
            'email' => 'nullable|email',
            'kepala_sekolah' => 'nullable|string|max:255',
            'nip_kepala_sekolah' => 'nullable|digits_between:8,18',
            'tahun_ajaran' => ['nullable', 'regex:/^[0-9]{4}\/[0-9]{4}$/'],
            'semester' => 'nullable|string|max:20',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'kop_surat' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'ttd_kepsek' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',

        ], [
            'nama_sekolah.max' => 'Nama sekolah maksimal 255 karakter.',
            'npsn.digits' => 'NPSN harus terdiri dari 8 digit angka.',
            'jenjang.max' => 'Jenjang maksimal 50 karakter.',
            'alamat.max' => 'Alamat maksimal 255 karakter.',
            'telepon.regex' => 'Nomor telepon hanya boleh berisi angka, spasi, + atau -.',
            'telepon.max' => 'Nomor telepon maksimal 20 karakter.',
            'email.email' => 'Format email tidak valid.',
            'kepala_sekolah.max' => 'Nama kepala sekolah maksimal 255 karakter.',
            'nip_kepala_sekolah.digits_between' => 'NIP harus berupa angka antara 8 sampai 18 digit.',
            'tahun_ajaran.regex' => 'Tahun ajaran harus berformat contoh: 2024/2025.',
            'semester.max' => 'Semester maksimal 20 karakter.',

            'logo.image' => 'Logo harus berupa file gambar.',
            'logo.mimes' => 'Logo harus berformat PNG, JPG, JPEG, atau WEBP.',
            'logo.max' => 'Ukuran logo maksimal 2MB.',

            'kop_surat.image' => 'Kop surat harus berupa file gambar.',
            'kop_surat.mimes' => 'Kop surat harus berformat PNG, JPG, JPEG, atau WEBP.',
            'kop_surat.max' => 'Ukuran kop surat maksimal 2MB.',

            'ttd_kepsek.image' => 'TTD Kepala Sekolah harus berupa file gambar.',
            'ttd_kepsek.mimes' => 'TTD Kepala Sekolah harus berformat PNG, JPG, JPEG, atau WEBP.',
            'ttd_kepsek.max' => 'Ukuran TTD maksimal 2MB.',
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

        return redirect()->route('admin.pengaturan.index')
                        ->with('success', 'Pengaturan sekolah berhasil diperbarui');
    }
}
