<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SiswaOrangtuaTemplateExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return new Collection([
            [
                'username_siswa' => '',
                'nama_siswa'     => '',
                'email_siswa'    => '',
                'nis'            => '',
                'nama_kelas'     => '',
                'alamat'         => '',
                'perwakilan'     => '',

                'username_ortu'  => '',
                'nama_ortu'      => '',
                'email_ortu'     => '',
                'no_hp_ortu'     => '',
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'username_siswa',
            'nama_siswa',
            'email_siswa',
            'nis',
            'nama_kelas',
            'alamat',
            'perwakilan',

            'username_ortu',
            'nama_ortu',
            'email_ortu',
            'no_hp_ortu',
        ];
    }
}