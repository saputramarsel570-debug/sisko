<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Guru;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\Importable;

class KelasImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public $inserted = 0;

    public function model(array $row)
    {
        if (empty($row['nama_kelas'])) {
            return null;
        }

        $namaKelas = trim($row['nama_kelas']);

        if (!preg_match('/^[A-Za-z0-9\s\.\-]+$/', $namaKelas)) {
            return null;
        }

        if (Kelas::whereRaw('LOWER(nama_kelas) = ?', strtolower($namaKelas))->exists()) {
            return null;
        }

        $wali = null;
        if (!empty($row['wali_kelas'])) {
            $wali = Guru::whereRaw('LOWER(nama) = ?', strtolower(trim($row['wali_kelas'])))->first();
        }

        $this->inserted++;

        return new Kelas([
            'nama_kelas'    => $namaKelas,
            'wali_kelas_id' => $wali ? $wali->id : null,
        ]);
    }

    public function rules(): array
    {
        return [
            '*.nama_kelas' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-z0-9\s\.\-]+$/',
                'unique:kelas,nama_kelas'
            ],

            '*.wali_kelas' => [
                'nullable',
                'string'
            ],
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.nama_kelas.max' => 'Nama kelas maksimal 255 karakter.',
            '*.nama_kelas.regex' => 'Nama kelas hanya boleh huruf, angka, spasi, titik, dan tanda minus.',
            '*.nama_kelas.unique' => 'Nama kelas sudah ada dalam database.',
        ];
    }
}