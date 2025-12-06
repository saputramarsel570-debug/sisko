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
    $pengumuman = Pengumuman::with('user')
        ->where(function ($query) {
            $query->whereNull('tanggal_berakhir')
                  ->orWhereDate('tanggal_berakhir', '>=', now());
        })
        ->latest()
        ->get();

    return view('pages.admin.pengumuman.index', compact('pengumuman'));
}

    public function create()
    {
        return view('pages.admin.pengumuman.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'target' => 'required|in:siswa,orangtua,semua',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:today',
        ], [
            'judul.max' => 'Judul pengumuman tidak boleh lebih dari 255 karakter.',
        
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
        
            'tanggal_berakhir.date' => 'Tanggal berakhir harus berupa tanggal yang valid.',
            'tanggal_berakhir.after_or_equal' => 'Tanggal berakhir tidak boleh sebelum hari ini.',
        ]);
    
        $validated['dibuat_oleh'] = auth()->id();
    
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('pengumuman', 'public');
        }
    
        $pengumuman = Pengumuman::create($validated);

        // Kirim notifikasi
        $targetUsers = collect();
        if ($validated['target'] === 'siswa') {
            $targetUsers = User::whereIn('role', ['siswa', 'siswa_perwakilan', 'orangtua'])->get();
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

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'target' => 'required|in:siswa,orangtua,semua',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'tanggal_berakhir' => 'nullable|date|after_or_equal:today',
        ], [
            // Judul
            'judul.max' => 'Judul pengumuman tidak boleh lebih dari 255 karakter.',
        
            // Gambar
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
        
            // Tanggal berakhir
            'tanggal_berakhir.date' => 'Tanggal berakhir harus berupa tanggal yang valid.',
            'tanggal_berakhir.after_or_equal' => 'Tanggal berakhir tidak boleh sebelum hari ini.',
        ]);

        $pengumuman = Pengumuman::findOrFail($id);

        // Gambar baru
        if ($request->hasFile('gambar')) {
            if ($pengumuman->gambar && Storage::disk('public')->exists($pengumuman->gambar)) {
                Storage::disk('public')->delete($pengumuman->gambar);
            }

            $validated['gambar'] = $request->file('gambar')->store('pengumuman', 'public');
        }

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
    public function arsip()
    {
        $pengumuman = Pengumuman::with('user')
            ->whereNotNull('tanggal_berakhir')
            ->whereDate('tanggal_berakhir', '<', now())
            ->latest()
            ->get();
    
        return view('pages.admin.pengumuman.arsip', compact('pengumuman'));
    }
}