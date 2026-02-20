# Phase 1: Laravel Setup + Role-Based Authentication

## 1) Install and bootstrap Laravel

```bash
composer create-project laravel/laravel exam_validator
cd exam_validator
cp .env.example .env
php artisan key:generate
```

Configure DB in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=exam_validator
DB_USERNAME=root
DB_PASSWORD=
```

## 2) Add authentication scaffolding (Breeze)

```bash
composer require laravel/breeze --dev
php artisan breeze:install
npm install
npm run build
php artisan migrate
```

## 3) Add role and permission package

```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

Update `app/Models/User.php`:

```php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
}
```

## 4) Seed initial roles

Create seeder `database/seeders/RoleAndAdminSeeder.php`:

```php
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
```

Register in `database/seeders/DatabaseSeeder.php`:

```php
$this->call(RoleAndAdminSeeder::class);
```

Run:

```bash
php artisan db:seed
```

## 5) Route-level protection

Use middleware for role-restricted sections:

```php
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    // blueprint management, tolerance settings, dashboards
});

Route::middleware(['auth', 'role:lecturer'])->prefix('lecturer')->group(function () {
    // exam creation, question entry, submit for compliance
});
```

## 6) Initial feature boundaries

- Admin can manage blueprints and tolerance settings.
- Lecturer can create exams and questions.
- Submission endpoint must reject non-compliant papers.

## 7) Security baseline

- Enforce password reset + email verification.
- Add login throttling.
- Log validation history per exam submission.
- Restrict all CRUD endpoints with authorization policies.
