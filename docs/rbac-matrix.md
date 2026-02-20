# RBAC Matrix (Phase 1)

| Module | Action | Admin | Lecturer |
|---|---|---:|---:|
| Authentication | Login/Logout | ✅ | ✅ |
| Blueprint | Create | ✅ | ❌ |
| Blueprint | Edit | ✅ | ❌ |
| Blueprint | Delete | ✅ | ❌ |
| Blueprint | Activate/Deactivate | ✅ | ❌ |
| Tolerance Settings | Configure | ✅ | ❌ |
| Exams | Create | ❌ | ✅ |
| Exams | Update own draft | ❌ | ✅ |
| Exams | Submit | ❌ | ✅ |
| Exams | Approve/Reject | ✅ | ❌ |
| Dashboards | Admin analytics | ✅ | ❌ |
| Dashboards | Personal compliance history | ❌ | ✅ |
| Reports | Export compliance reports | ✅ | ✅ (own exams only) |

## Roles
- `admin`
- `lecturer`

## Suggested permissions (Spatie)

- `blueprint.create`
- `blueprint.update`
- `blueprint.delete`
- `blueprint.toggle`
- `tolerance.manage`
- `exam.create`
- `exam.update`
- `exam.submit`
- `exam.review`
- `report.export`
- `dashboard.admin.view`
- `dashboard.lecturer.view`

Assign all `blueprint.*`, `tolerance.manage`, `exam.review`, `dashboard.admin.view` to `admin`.

Assign `exam.create`, `exam.update`, `exam.submit`, `dashboard.lecturer.view`, and constrained `report.export` to `lecturer`.
