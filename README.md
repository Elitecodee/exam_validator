# Exam Validator

This repository now contains a **Laravel-ready Phase 1 starter** focused on:
- Project setup steps
- Role-based authentication
- Initial page flow for Admin and Lecturer

## What is included now

### 1) Setup and auth flow (implemented as starter code)
- `routes/web.php` with:
  - Login / Register / Logout routes
  - Admin-protected dashboard route
  - Lecturer-protected dashboard + exam routes
- `app/Http/Controllers/Auth/AuthController.php`:
  - Login, register, and logout handlers
  - Role-based post-login redirect
- `app/Http/Middleware/EnsureUserHasRole.php`:
  - Generic role gate middleware

### 2) Pages written out (Blade templates)
- Authentication pages:
  - `resources/views/auth/login.blade.php`
  - `resources/views/auth/register.blade.php`
- Admin pages:
  - `resources/views/admin/dashboard.blade.php`
- Lecturer pages:
  - `resources/views/lecturer/dashboard.blade.php`
  - `resources/views/lecturer/exams-index.blade.php`
  - `resources/views/lecturer/exams-create.blade.php`
  - `resources/views/lecturer/exams-show.blade.php`
- Shared layout:
  - `resources/views/layouts/app.blade.php`

### 3) Data bootstrap for roles
- `database/migrations/2026_01_01_000001_add_role_to_users_table.php`
- `database/seeders/RoleAndAdminSeeder.php`

## How to apply in a fresh Laravel app

1. Scaffold Laravel in a network-enabled environment.
2. Copy these starter files into the Laravel project.
3. Register middleware alias `role` in bootstrap/app config.
4. Run migrations and seeders.
5. Start server and test login by role.

## Next implementation step
After this phase, we implement:
- Blueprint CRUD (Admin)
- Exam question entry + real-time validation (Lecturer)
- Final compliance check and reports
