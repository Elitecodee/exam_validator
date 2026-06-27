# Phase 3: Reporting Module (PDF/Export/Charts)

## Implemented reporting features

Admin reporting module now provides:
- Compliance summary KPIs
- Chart-ready data for:
  - compliance rate by lecturer
  - common rule violations
- Downloadable CSV exports:
  - compliance summary CSV
  - detailed distribution breakdown CSV
- Printable report page for PDF export via browser print (`Save as PDF`)

## Routes

- `GET /admin/reports`
- `GET /admin/reports/chart-data`
- `GET /admin/reports/compliance.csv`
- `GET /admin/reports/distribution.csv`
- `GET /admin/reports/printable`

All routes are protected by `auth` + `role:admin`.

## Notes

- The printable page is intentionally optimized for browser print/PDF workflows.
- Chart data is exposed as JSON so any chart library can consume it.
