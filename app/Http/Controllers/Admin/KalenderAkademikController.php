<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KalenderAkademik;

class KalenderAkademikController extends Controller
{
    public function index()
    {
        // Ambil event dari database
        $kalender = KalenderAkademik::all()->map(function($item) {
            return [
                'id' => $item->id,
                'title' => $item->judul,
                'start' => $item->tanggal_mulai->toDateString(),
                'end' => $item->tanggal_selesai ? $item->tanggal_selesai->toDateString() : null,
                'extendedProps' => [
                    'kategori' => $item->kategori
                ]
            ];
        })->toArray();

        // Dummy event jika database kosong
        if (empty($kalender)) {
            $kalender = [
                [
                    'id' => 1,
                    'title' => 'Libur Nasional',
                    'start' => now()->toDateString(),
                    'end' => now()->addDay()->toDateString(),
                    'extendedProps' => ['kategori' => 'Libur Nasional']
                ],
                [
                    'id' => 2,
                    'title' => 'Ujian Tengah Semester',
                    'start' => now()->addDays(3)->toDateString(),
                    'extendedProps' => ['kategori' => 'Ujian']
                ]
            ];
        }

        return view('pages.admin.kalender_akademik.index', compact('kalender'));
    }
}
