<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Siswa;
use App\Models\OrangTua;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class SiswaOrangtuaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $roleSiswa = (isset($row['perwakilan']) && strtolower($row['perwakilan']) === 'ya') ? 'siswa_perwakilan' : 'siswa';

        $userSiswa = User::create([
            'username' => $row['nis'],
            'name'     => $row['nama_siswa'],
            'email'    => $row['email_siswa'] ?? $row['nis'].'@mail.com',
            'password' => Hash::make('password'),
            'role'     => $roleSiswa,
        ]);

        $siswa = Siswa::create([
            'user_id'  => $userSiswa->id,
            'nis'      => $row['nis'],
            'nama'     => $row['nama_siswa'],
            'kelas_id' => $row['kelas_id'],
            'alamat'   => $row['alamat'] ?? null,
        ]);

        $userOrtu = User::create([
            'username' => 'ortu_' . $row['nis'],
            'name'     => $row['nama_ortu'],
            'email'    => $row['email_ortu'] ?? 'ortu_'.$row['nis'].'@mail.com',
            'password' => Hash::make('password'),
            'role'     => 'orangtua',
        ]);

        OrangTua::create([
            'user_id'  => $userOrtu->id,
            'siswa_id' => $siswa->id,
            'nama'     => $row['nama_ortu'],
            'no_hp'    => $row['no_hp'] ?? null,
        ]);

        return $siswa;
    }
}
