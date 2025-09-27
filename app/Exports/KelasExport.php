<?php

namespace App\Exports;

use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class KelasExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Kelas::with('waliKelas')->get();
    }

    public function map($kelas): array
    {
        return [
            $kelas->id,
            $kelas->nama_kelas,
            $kelas->waliKelas->nama ?? '-',
            $kelas->created_at,
            $kelas->updated_at,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Kelas',
            'Wali Kelas',
            'Dibuat Pada',
            'Diperbarui Pada',
        ];
    }
}
