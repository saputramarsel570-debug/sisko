<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KelasTemplateExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return new Collection([
            [
                'nama_kelas' => '',
                'wali_kelas' => '',
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'nama_kelas',
            'wali_kelas',
        ];
    }
}