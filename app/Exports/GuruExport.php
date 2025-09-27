<?php

namespace App\Exports;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class GuruExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Guru::with('user')->get();
    }

    public function map($guru): array
    {
        return [
            $guru->id,
            $guru->user->username ?? '-',
            $guru->user->email ?? '-',
            $guru->nip,
            $guru->nama,
            $guru->mapel,
            $guru->created_at,
            $guru->updated_at,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Username',
            'Email',
            'NIP',
            'Nama Guru',
            'Mata Pelajaran',
            'Dibuat Pada',
            'Diperbarui Pada',
        ];
    }
}
