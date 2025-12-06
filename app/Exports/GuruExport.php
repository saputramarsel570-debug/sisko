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
        return Guru::with(['user', 'mataPelajaran'])->get();
    }

    public function map($guru): array
    {
        return [
            $guru->id,
            $guru->user->username ?? '-',
            $guru->user->email ?? '-',
            $guru->nip ?? '-',
            $guru->nama ?? '-',
            $guru->mataPelajaran->nama_mapel ?? '-',
            $guru->created_at
            ? $guru->created_at->copy()->timezone('Asia/Jakarta')->format('Y-m-d H:i')
            : '-',
            $guru->updated_at
            ? $guru->updated_at->copy()->timezone('Asia/Jakarta')->format('Y-m-d H:i')
            : '-',
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
