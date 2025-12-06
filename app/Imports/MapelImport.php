<?php

namespace App\Imports;

use App\Models\MataPelajaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\Importable;

class MapelImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public $inserted = 0;

    public function model(array $row)
    {
        if (empty($row['kode_mapel']) || empty($row['nama_mapel'])) {
            return null;
        }

        if (MataPelajaran::where('kode_mapel', $row['kode_mapel'])->exists()) {
            return null;
        }

        if (MataPelajaran::whereRaw('LOWER(nama_mapel) = ?', strtolower($row['nama_mapel']))->exists()) {
            return null;
        }

        $this->inserted++;

        return new MataPelajaran([
            'kode_mapel' => trim($row['kode_mapel']),
            'nama_mapel' => trim($row['nama_mapel']),
        ]);
    }

    public function rules(): array
    {
        return [
            '*.kode_mapel' => [
                'required',
                'string',
                'max:20',
                'regex:/^[A-Za-z0-9\-_]+$/',
                'unique:mata_pelajaran,kode_mapel'
            ],
            '*.nama_mapel' => [
                'required',
                'string',
                'max:255',
                'unique:mata_pelajaran,nama_mapel',
            ],
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.kode_mapel.max' => 'Kode mapel maksimal 20 karakter.',
            '*.kode_mapel.regex' => 'Kode mapel hanya boleh huruf, angka, dash, dan underscore.',
            '*.kode_mapel.unique' => 'Kode mapel sudah ada di database.',

            '*.nama_mapel.max' => 'Nama mata pelajaran maksimal 255 karakter.',
            '*.nama_mapel.unique' => 'Nama mata pelajaran sudah ada di database.',
        ];
    }
}