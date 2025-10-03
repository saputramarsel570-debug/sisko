<?php

namespace App\Imports;

use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\MataPelajaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class JadwalPelajaranImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $kelas = Kelas::where('nama_kelas', $row['nama_kelas'])->first();
        $mapel = MataPelajaran::where('nama_mapel', $row['nama_mapel'])->first();
        $guru  = Guru::where('nama', $row['nama_guru'])->first();

        if (!$kelas || !$mapel || !$guru) {
            Log::warning('Data tidak ditemukan saat import jadwal', [
                'kelas' => $row['nama_kelas'] ?? null,
                'mapel' => $row['nama_mapel'] ?? null,
                'guru'  => $row['nama_guru'] ?? null,
            ]);
            return null;
        }

        return new JadwalPelajaran([
            'kelas_id'           => $kelas->id,
            'mata_pelajaran_id'  => $mapel->id,
            'guru_id'            => $guru->id,
            'hari'               => $row['hari'],
            'jam_mulai'          => (int) $row['jam_mulai'],
            'jam_selesai'        => (int) $row['jam_selesai'],
        ]);
    }
}
