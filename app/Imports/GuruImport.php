<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\User;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuruImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $mataPelajaran = MataPelajaran::where('nama_mapel', $row['mata_pelajaran'] ?? $row['mapel'] ?? null)->first();

        $user = User::firstOrCreate(
            ['email' => $row['email']],
            [
                'username' => $row['username'],
                'name' => $row['nama'],
                'profile_photo' => null,
                'password' => Hash::make('password123'),
                'role' => 'guru',
            ]
        );

        return new Guru([
            'user_id' => $user->id,
            'nip' => $row['nip'] ?? null,
            'nama' => $row['nama'],
            'mata_pelajaran_id' => $mataPelajaran ? $mataPelajaran->id : null,
        ]);
    }
}
