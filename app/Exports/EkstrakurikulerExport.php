<?php

namespace App\Exports;

use App\Models\Ekstrakurikuler;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EkstrakurikulerExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Ekstrakurikuler::all();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Ekskul',
            'Deskripsi',
            'Nama Pembina',
            'Foto',
            'Tanggal Dibuat',
            'Terakhir Update',
        ];
    }

    public function map($ekskul): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $ekskul->nama,
            $ekskul->deskripsi,
            $ekskul->nama_pembina,
            $ekskul->foto ? asset('storage/' . $ekskul->foto) : '-',
            $ekskul->created_at ? $ekskul->created_at->format('Y-m-d') : '-',
            $ekskul->updated_at ? $ekskul->updated_at->format('Y-m-d') : '-',
        ];
    }
}
