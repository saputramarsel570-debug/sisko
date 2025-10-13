<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengumuman;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Notifications\PengumumanBaruNotification;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::with('user')->latest()->get();
        return view('pages.admin.pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        return view('pages.admin.pengumuman.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'  => 'required|string|max:255',
            'isi'    => 'required|string',
            'target' => 'required|in:siswa,orangtua,semua',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['dibuat_oleh'] = auth()->id();

        // Simpan gambar ke storage/public/pengumuman
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('pengumuman', 'public');
            $validated['gambar'] = $path;
        }

        $pengumuman = Pengumuman::create($validated);

        // Kirim notifikasi
        $targetUsers = collect();
        if ($validated['target'] === 'siswa') {
            $targetUsers = User::whereIn('role', ['siswa', 'siswa_perwakilan'])->get();
        } elseif ($validated['target'] === 'orangtua') {
            $targetUsers = User::where('role', 'orangtua')->get();
        } else {
            $targetUsers = User::whereIn('role', ['siswa', 'siswa_perwakilan', 'orangtua'])->get();
        }

        foreach ($targetUsers as $user) {
            $user->notify(new PengumumanBaruNotification(
                $pengumuman->judul,
                $pengumuman->isi,
                $pengumuman->id
            ));
        }

        return redirect()
            ->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman terbaru berhasil dikirim');
    }

    public function show(string $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('pages.admin.pengumuman.show', compact('pengumuman'));
    }

    public function edit(string $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('pages.admin.pengumuman.edit', compact('pengumuman'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'target' => 'required|in:siswa,orangtua,semua',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $pengumuman = Pengumuman::findOrFail($id);

        // Hapus gambar lama jika upload baru
        if ($request->hasFile('gambar')) {
            if ($pengumuman->gambar && Storage::disk('public')->exists($pengumuman->gambar)) {
                Storage::disk('public')->delete($pengumuman->gambar);
            }

            $path = $request->file('gambar')->store('pengumuman', 'public');
            $validated['gambar'] = $path;
        }

        $validated['dibuat_oleh'] = auth()->id();

        $pengumuman->update($validated);

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        if ($pengumuman->gambar && Storage::disk('public')->exists($pengumuman->gambar)) {
            Storage::disk('public')->delete($pengumuman->gambar);
        }

        $pengumuman->delete();

        return redirect()->route('admin.pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus');
    }
}