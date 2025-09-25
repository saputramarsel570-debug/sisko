<?php

namespace App\Imports;

use App\Models\JadwalPelajaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JadwalPelajaranImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new JadwalPelajaran([
            'kelas_id' => $row['kelas_id'],
            'mata_pelajaran_id' => $row['mata_pelajaran_id'],
            'guru_id' => $row['guru_id'],
            'hari' => $row['hari'],
            'jam_mulai' => $row['jam_mulai'],
            'jam_selesai' => $row['jam_selesai'],
        ]);
    }
}
