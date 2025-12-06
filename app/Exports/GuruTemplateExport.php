<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GuruTemplateExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return new Collection([
            [
                'nama'            => '',
                'username'        => '',
                'email'           => '',
                'nip'             => '',
                'mata_pelajaran'  => '',
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'nama',
            'username',
            'email',
            'nip',
            'mata_pelajaran',
        ];
    }
}