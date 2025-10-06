<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserExport implements FromCollection, WithHeadings, WithMapping
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
            'updated_at',
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
            'Updated At',
        ];
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->username,
            $user->name,
            $user->email,
            $user->profile_photo,
            $user->email_verified_at,
            $user->role,
            $user->created_at ? $user->created_at->format('d-m-Y H:i') : null,
            $user->updated_at ? $user->updated_at->format('d-m-Y H:i') : null,
        ];
    }
}
