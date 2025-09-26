<?php

namespace App\Exports;

use App\Models\MataPelajaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MataPelajaranExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MataPelajaran::all();
    }

    public function map($mapel): array
    {
        return [
            $mapel->id,
            $mapel->kode_mapel,
            $mapel->nama_mapel,
            $mapel->created_at ? $mapel->created_at->format('Y-m-d H:i') : '-',
            $mapel->updated_at ? $mapel->updated_at->format('Y-m-d H:i') : '-',
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Kode Mapel',
            'Nama Mapel',
            'Dibuat',
            'Update Terakhir',
        ];
    }
}
