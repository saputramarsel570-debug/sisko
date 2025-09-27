<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::select(
            'id',
            'username',
            'name',
            'email',
            'profile_photo',
            'email_verified_at',
            'role',
            'created_at',
            'updated_at'
        )->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Username',
            'Name',
            'Email',
            'Profile Photo',
            'Email Verified At',
            'Role',
            'Created At',
            'Updated At'
        ];
    }
}
