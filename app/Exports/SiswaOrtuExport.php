<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SiswaOrtuExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Siswa::with(['user', 'kelas', 'orangTua.user'])->get();
    }

    public function headings(): array
    {
        return [
            'NIS',
            'Nama Siswa',
            'Kelas',
            'Alamat',
            'Username Siswa',
            'Email Siswa',
            'Nama Ortu',
            'No HP Ortu',
            'Username Ortu',
            'Email Ortu',
        ];
    }

    public function map($siswa): array
    {
        $ortu = $siswa->orangTua->first();

        return [
            $siswa->nis,
            $siswa->nama,
            $siswa->kelas->nama_kelas ?? '-',
            $siswa->alamat,
            $siswa->user->username ?? '-',
            $siswa->user->email ?? '-',
            $ortu->nama ?? '-',
            $ortu->no_hp ?? '-',
            $ortu->user->username ?? '-' ,
            $ortu->user->email ?? '-' ,
        ];
    }
}
