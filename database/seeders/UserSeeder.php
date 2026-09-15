<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        User::updateOrCreate(
            ['email' => 'iyainajadeh95@gmail.com'],
            [
                'username' => 'rafi superadmin',
                'name' => 'Haidar Rafi',
                'password' => Hash::make('superadmin123'),
                'role' => 'superadmin',
                'is_active' => true,
            ]
        );
    }
}
