<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\User;
use App\Models\MataPelajaran;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\Importable;

class GuruImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public $inserted = 0;

    /**
     * Membersihkan input sebelum validasi
     */
    public function prepareForValidation(array $data)
    {
        foreach ($data as $i => $row) {

            if (isset($row['username'])) {
                $data[$i]['username'] = strtolower(trim($row['username']));
            }

            if (isset($row['email'])) {
                $data[$i]['email'] = strtolower(trim($row['email']));
            }

            if (isset($row['nama'])) {
                $data[$i]['nama'] = trim($row['nama']);
            }

            if (isset($row['mata_pelajaran'])) {
                $data[$i]['mata_pelajaran'] = trim($row['mata_pelajaran']);
            }
        }

        return $data;
    }


    /**
     * Simpan data
     */
    public function model(array $row)
    {
        if (empty($row['nama']) || empty($row['username']) || empty($row['email'])) {
            return null;
        }

        // Cek duplikasi user
        if (User::where('username', strtolower($row['username']))->exists()) {
            return null;
        }

        if (User::where('email', strtolower($row['email']))->exists()) {
            return null;
        }

        // Validasi mapel sesuai controller (nullable, tapi jika diisi harus ada)
        $mataPelajaran = null;

        if (!empty($row['mata_pelajaran'])) {
            $mataPelajaran = MataPelajaran::whereRaw(
                'LOWER(nama_mapel) = ?',
                strtolower($row['mata_pelajaran'])
            )->first();

            if (!$mataPelajaran) {
                return null; 
            }
        }

        // Cek NIP unik
        if (!empty($row['nip'])) {
            if (Guru::where('nip', $row['nip'])->exists()) {
                return null;
            }
        }

        // Insert user
        $user = User::create([
            'username' => strtolower($row['username']),
            'name' => $row['nama'],
            'email' => strtolower($row['email']),
            'password' => Hash::make('password123'),
            'role' => 'guru',
        ]);

        $this->inserted++;

        return new Guru([
            'user_id' => $user->id,
            'nip' => $row['nip'] ?? null,
            'nama' => $row['nama'],
            'mata_pelajaran_id' => $mataPelajaran?->id,
        ]);
    }


    /**
     * Validasi kolom
     */
    public function rules(): array
    {
        return [

            '*.nama' => [
                'required',
                'string',
                'max:255',
            ],

            '*.username' => [
                'required',
                'min:4', 
                'max:50',
                'regex:/^[a-z0-9_]+$/',
                Rule::unique('users', 'username'),
            ],

            '*.email' => [
                'required',
                'email',
                'max:255',
                'regex:/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/', 
                Rule::unique('users', 'email'),
            ],

            '*.nip' => [
                'nullable',
                'numeric',
                'digits_between:5,25',
                Rule::unique('guru', 'nip'),
            ],

            '*.mata_pelajaran' => [
                'nullable',
                'string',
                'max:100',
            ],
        ];
    }


    /**
     * Pesan error
     */
    public function customValidationMessages()
    {
        return [
            '*.nama.required' => 'Nama guru wajib diisi.',
            '*.nama.max'      => 'Nama guru maksimal 255 karakter.',

            '*.username.required' => 'Username wajib diisi.',
            '*.username.min'      => 'Username minimal 4 karakter.',
            '*.username.max'      => 'Username maksimal 50 karakter.',
            '*.username.regex'    => 'Username hanya boleh huruf kecil, angka, dan underscore.',
            '*.username.unique'   => 'Username sudah digunakan.',

            '*.email.required' => 'Email wajib diisi.',
            '*.email.email'    => 'Format email tidak valid.',
            '*.email.max'      => 'Email maksimal 255 karakter.',
            '*.email.unique'   => 'Email sudah digunakan.',
            '*.email.regex'    => 'Format email tidak valid.',

            '*.nip.numeric'        => 'NIP hanya boleh berisi angka.',
            '*.nip.digits_between' => 'NIP harus 5-25 digit angka.',
            '*.nip.unique'         => 'NIP sudah ada.',

            '*.mata_pelajaran.max' => 'Nama mata pelajaran maksimal 100 karakter.',
        ];
    }
}