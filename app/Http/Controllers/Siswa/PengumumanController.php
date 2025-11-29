<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengumuman;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengumuman = Pengumuman::whereIn('target', ['semua', 'siswa'])
            ->where(function ($query) {
                $query->whereNull('tanggal_berakhir')
                    ->orWhereDate('tanggal_berakhir', '>=', now());
            })
            ->latest()
            ->get();

        $featured = $pengumuman->first();
        $others = $pengumuman->skip(1);

        return view('pages.siswa.pengumuman.index', compact('featured', 'others'));
    }
    public function show(string $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('pages.siswa.pengumuman.show', compact('pengumuman'));
    }
    public function arsip(Request $request)
    {
        $query = Pengumuman::whereIn('target', ['semua', 'siswa'])
            ->whereNotNull('tanggal_berakhir')
            ->whereDate('tanggal_berakhir', '<', now());
    
        if ($request->search) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }
    
        $pengumuman = $query->latest()->get();
    
        return view('pages.siswa.pengumuman.arsip', compact('pengumuman'));
    }
}
