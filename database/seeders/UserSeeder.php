<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'raja',
            'name' => 'Gentar Si Raja Iblis',
            'email' => 'raja@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('raja12345'),
            'remember_token' => Str::random(10),
            'role' => 'admin',
        ]);

        User::create([
            'username' => 'rogan',
            'name' => 'RoVerteng',
            'email' => 'rogan@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('rogan12345'),
            'remember_token' => Str::random(10),
            'role' => 'guru',
        ]);

        User::create([
            'username' => 'marhak',
            'name' => 'Marsel Baehaki',
            'email' => 'marhak@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('marhak12345'),
            'remember_token' => Str::random(10),
            'role' => 'siswa',
        ]);

        User::create([
            'username' => 'admin',
            'name' => 'Super Duper Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'remember_token' => Str::random(10),
            'role' => 'admin',
        ]);

        User::create([
            'username' => 'guru',
            'name' => 'Guru Besar',
            'email' => 'guru@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('guru456'),
            'remember_token' => Str::random(10),
            'role' => 'guru',
        ]);

        User::create([
            'username' => 'siswa',
            'name' => 'Siswa Baik',
            'email' => 'siswa@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('siswa789'),
            'remember_token' => Str::random(10),
            'role' => 'siswa',
        ]);

        User::create([
            'username' => 'orangtua',
            'name' => 'Orangtua Siswa',
            'email' => 'orangtua@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('orangtua12345'),
            'remember_token' => Str::random(10),
            'role' => 'orangtua',
        ]);
    }
}
