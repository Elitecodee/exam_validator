<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleAndAdminSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $lecturerRole = Role::firstOrCreate(['name' => 'lecturer']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@exam-validator.local'],
            [
                'name' => 'Department Officer',
                'password' => Hash::make('ChangeMe123!'),
            ]
        );

        $admin->assignRole($adminRole);
    }
}