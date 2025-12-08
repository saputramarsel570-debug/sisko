<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Siswa;
use App\Models\OrangTua;
use App\Models\Kelas;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class SiswaOrangtuaImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    // Counter untuk controller
    public $inserted = 0;

    public function model(array $row)
    {
        // ============================
        // NORMALISASI INPUT
        // ============================
        $usernameSiswa = strtolower($row['username_siswa']);
        $usernameOrtu  = strtolower($row['username_ortu'] ?? 'ortu_' . $row['nis']);

        $emailSiswa = strtolower($row['email_siswa'] ?? $row['nis'] . '@sekolah.com');
        $emailOrtu  = strtolower($row['email_ortu'] ?? 'ortu_' . $row['nis'] . '@sekolah.com');

        // ============================
        // AUTO PERBAIKAN DUPLIKAT
        // ============================
        $usernameSiswa = $this->uniqueUsername($usernameSiswa);
        $usernameOrtu  = $this->uniqueUsername($usernameOrtu);

        $emailSiswa = $this->uniqueEmail($emailSiswa);
        $emailOrtu  = $this->uniqueEmail($emailOrtu);

        // ============================
        // ROLE SISWA
        // ============================
        $roleSiswa = (
            isset($row['perwakilan']) &&
            in_array(strtolower($row['perwakilan']), ['ya'])
        ) ? 'siswa_perwakilan' : 'siswa';

        // ============================
        // VALIDASI KELAS
        // ============================
        $kelas = Kelas::where('nama_kelas', $row['nama_kelas'])->first();

        // ============================
        // USER SISWA
        // ============================
        $userSiswa = User::create([
            'username' => $usernameSiswa,
            'name'     => $row['nama_siswa'],
            'email'    => $emailSiswa,
            'password' => Hash::make($row['nis']),     // Password = NIS
            'role'     => $roleSiswa,
        ]);

        // ============================
        // DATA SISWA
        // ============================
        $siswa = Siswa::create([
            'user_id'  => $userSiswa->id,
            'nis'      => $row['nis'],
            'nama'     => $row['nama_siswa'],
            'kelas_id' => $kelas->id,
            'alamat'   => $row['alamat'] ?? null,
        ]);

        // ============================
        // USER ORTU
        // ============================
        $userOrtu = User::create([
            'username' => $usernameOrtu,
            'name'     => $row['nama_ortu'],
            'email'    => $emailOrtu,
            'password' => Hash::make($row['nis']),     // Password = NIS juga
            'role'     => 'orangtua',
        ]);

        // ============================
        // DATA ORANG TUA
        // ============================
        OrangTua::create([
            'user_id'  => $userOrtu->id,
            'siswa_id' => $siswa->id,
            'nama'     => $row['nama_ortu'],
            'no_hp'    => $row['no_hp_ortu'] ?? null,
        ]);

        // Tambah counter
        $this->inserted++;

        return $siswa;
    }

    // ========================================================
    // AUTO-GENERATE USERNAME UNIK
    // ========================================================
    private function uniqueUsername($username)
    {
        $original = $username;
        $i = 1;

        while (User::where('username', $username)->exists()) {
            $username = $original . '_' . $i;
            $i++;
        }

        return $username;
    }

    // ========================================================
    // AUTO-GENERATE EMAIL UNIK
    // ========================================================
    private function uniqueEmail($email)
    {
        $originalLocalPart = explode('@', $email)[0];
        $i = 1;

        while (User::where('email', $email)->exists()) {
            $email = $originalLocalPart . $i . '@sekolah.com';
            $i++;
        }

        return $email;
    }

    // ========================================================
    // VALIDASI
    // ========================================================
    public function rules(): array
    {
        return [
            '*.nis' => ['required', 'numeric', 'digits_between:5,25', 'unique:siswa,nis'],
            '*.nama_siswa' => ['required', 'string', 'max:255'],
            '*.username_siswa' => ['required', 'min:4', 'max:50', 'regex:/^[a-z0-9_]+$/'],
            '*.email_siswa' => ['nullable', 'email', 'regex:/^[a-z0-9@._-]+$/'],
            '*.nama_kelas' => ['required', 'exists:kelas,nama_kelas'],

            '*.nama_ortu' => ['required', 'string', 'max:255'],
            '*.username_ortu' => ['nullable', 'min:4', 'max:50', 'regex:/^[a-z0-9_]+$/'],
            '*.email_ortu' => ['nullable', 'email', 'regex:/^[a-z0-9@._-]+$/'],
            '*.no_hp_ortu' => ['nullable', 'string', 'max:20'],
            '*.perwakilan' => ['nullable', 'in:ya,tidak,Ya,Tidak,YA,TIDAK'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            // Siswa
            '*.nis.required' => 'NIS wajib diisi.',
            '*.nis.numeric' => 'NIS harus berupa angka.',
            '*.nis.digits_between' => 'NIS harus 5 sampai 25 digit.',
            '*.nis.unique' => 'NIS sudah digunakan.',

            '*.nama_siswa.required' => 'Nama siswa wajib diisi.',
            '*.nama_siswa.max' => 'Nama siswa maksimal 255 karakter.',

            '*.username_siswa.required' => 'Username siswa wajib diisi.',
            '*.username_siswa.min' => 'Username siswa minimal 4 karakter.',
            '*.username_siswa.max' => 'Username siswa maksimal 50 karakter.',
            '*.username_siswa.regex' => 'Username siswa hanya boleh huruf kecil, angka, dan underscore.',

            '*.email_siswa.email' => 'Format email siswa tidak valid.',
            '*.email_siswa.regex' => 'Email siswa mengandung karakter tidak valid.',

            '*.nama_kelas.required' => 'Nama kelas wajib diisi.',
            '*.nama_kelas.exists' => 'Nama kelas tidak terdaftar.',

            // Orang tua
            '*.nama_ortu.required' => 'Nama orang tua wajib diisi.',
            '*.nama_ortu.max' => 'Nama orang tua maksimal 255 karakter.',

            '*.username_ortu.min' => 'Username orang tua minimal 4 karakter.',
            '*.username_ortu.max' => 'Username orang tua maksimal 50 karakter.',
            '*.username_ortu.regex' => 'Username orang tua hanya boleh huruf kecil, angka, dan underscore.',

            '*.email_ortu.email' => 'Format email orang tua tidak valid.',
            '*.email_ortu.regex' => 'Email orang tua mengandung karakter tidak valid.',

            '*.no_hp_ortu.max' => 'Nomor HP orang tua maksimal 20 karakter.',

            '*.perwakilan.in' => 'Kolom perwakilan hanya boleh: ya / tidak.',
        ];
    }
}