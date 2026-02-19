# Exam Validator

This repository contains a Laravel-oriented starter for building an exam validator system with role-based access and blueprint-driven rules.

## Current implemented scope

### Phase 1 (completed)
- Authentication flow (login/register/logout)
- Role-based route protection for Admin and Lecturer
- Starter dashboard pages and lecturer exam flow placeholders

### Phase 2 (started): Admin Blueprint Settings
Admin blueprint management is now scaffolded with CRUD + activation toggle.

Admin can:
- Create blueprint
- Define total marks
- Define theory/problem-solving percentages
- Define topic percentages with min/max limits
- Define difficulty percentages with min/max limits
- Edit/delete/activate/deactivate blueprint

System validates blueprint integrity on save:
- Theory + problem-solving = 100%
- Topic expected totals = 100%
- Difficulty expected totals = 100%
- Expected values must be within min/max limits

## Main files
- Routes: `routes/web.php`
- Admin blueprint controller: `app/Http/Controllers/Admin/BlueprintController.php`
- Models: `app/Models/Blueprint.php`, `app/Models/BlueprintRule.php`
- Blueprint pages:
  - `resources/views/admin/blueprints/index.blade.php`
  - `resources/views/admin/blueprints/create.blade.php`
  - `resources/views/admin/blueprints/edit.blade.php`
  - `resources/views/admin/blueprints/_form.blade.php`
- Migrations:
  - `database/migrations/2026_01_01_000002_create_blueprints_table.php`
  - `database/migrations/2026_01_01_000003_create_blueprint_rules_table.php`
- Docs: `docs/admin-blueprint-management.md`

## Next steps
- Connect blueprint forms to real course records
- Add blueprint detail view and chart summary
- Build lecturer-side real-time compliance computation against blueprint rules
- Add final submit compliance report with pass/fail and correction guidance
