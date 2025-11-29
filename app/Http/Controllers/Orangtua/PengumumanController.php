<?php

namespace App\Http\Controllers\Orangtua;
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
    $pengumuman = Pengumuman::whereIn('target', ['semua', 'orangtua'])
        ->where(function ($query) {
            $query->whereNull('tanggal_berakhir')
                  ->orWhereDate('tanggal_berakhir', '>=', now());
        })
        ->latest()
        ->get();

    $featured = $pengumuman->first();
    $others = $pengumuman->skip(1);

    return view('pages.orangtua.pengumuman.index', compact('featured', 'others'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('pages.orangtua.pengumuman.show', compact('pengumuman'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function arsip(Request $request)
    {
        $query = Pengumuman::whereIn('target', ['semua', 'orangtua'])
            ->whereNotNull('tanggal_berakhir')
            ->whereDate('tanggal_berakhir', '<', now());
    
        if ($request->search) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }
    
        $pengumuman = $query->latest()->get();
    
        return view('pages.orangtua.pengumuman.arsip', compact('pengumuman'));
    }
}
