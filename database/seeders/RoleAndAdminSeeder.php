<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleAndAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@exam-validator.local'],
            [
                'name' => 'Department Officer',
                'password' => Hash::make('ChangeMe123!'),
                'role' => 'admin',
            ]
        );
    }
}
