<?php

namespace App\Exports;

use App\Models\JadwalEkskul;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class JadwalEkskulExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return JadwalEkskul::with('ekstrakurikuler')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Ekskul',
            'Hari',
            'Tanggal Dibuat',
            'Terakhir Update',
        ];
    }

    public function map($jadwal): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $jadwal->ekstrakurikuler->nama ?? '-',
            $jadwal->hari,
            $jadwal->created_at ? $jadwal->created_at->format('Y-m-d') : '-',
            $jadwal->updated_at ? $jadwal->updated_at->format('Y-m-d') : '-',
        ];
    }
}
