# Admin Analytics & Reporting

## Implemented KPIs

Admin dashboard now includes:
- Total blueprints
- Total exams
- Total validation attempts
- Overall compliance rate (%)

## Compliance rate by lecturer

Computed from validation history grouped by `lecturer_id`:
- attempts
- passes
- fails
- compliance rate = passes / attempts * 100

## Common rule violations

Violations are extracted from each validation snapshot (`summary.violations`) and aggregated by rule key.

## Downloadable report

A CSV export endpoint is provided:
- Route: `GET /admin/reports/compliance.csv`
- Columns:
  - Validation ID
  - Exam ID
  - Lecturer ID
  - Result
  - Validated At

## Routes

- `GET /admin/dashboard`
- `GET /admin/analytics`
- `GET /admin/reports/compliance.csv`

All protected by `auth` + `role:admin`.
