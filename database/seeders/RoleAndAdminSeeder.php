<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleAndAdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@exam-validator.local'],
            [
                'name' => 'Department Officer',
                'password' => Hash::make('ChangeMe123!'),
                'role' => 'admin',
            ]
        );

        if ($admin->role !== 'admin') {
            $admin->forceFill(['role' => 'admin'])->save();
        }

        if (class_exists('Spatie\Permission\Models\Role')) {
            \Spatie\Permission\Models\Role::findOrCreate('admin', 'web');
            \Spatie\Permission\Models\Role::findOrCreate('lecturer', 'web');
        }

        if (method_exists($admin, 'assignRole') && !$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }
    }
}
