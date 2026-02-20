# Admin Blueprint Management (Phase 2 Start)

## Implemented in this step

Admin can now:
- Create blueprint
- Define total marks
- Define theory vs problem solving percentages
- Define topic coverage percentages with min/max limits
- Define difficulty distribution with min/max limits
- Edit blueprint
- Delete blueprint
- Activate/deactivate blueprint

## Validation rules implemented

When saving a blueprint, system validates:
1. `theory_percentage + problem_solving_percentage = 100`
2. Sum of topic expected percentages = `100`
3. Sum of difficulty expected percentages = `100`
4. For each topic/difficulty rule: `min <= expected <= max`

## Routes

- `GET /admin/blueprints`
- `GET /admin/blueprints/create`
- `POST /admin/blueprints`
- `GET /admin/blueprints/{blueprint}/edit`
- `PUT /admin/blueprints/{blueprint}`
- `PATCH /admin/blueprints/{blueprint}/toggle`
- `DELETE /admin/blueprints/{blueprint}`

All routes require `auth` and `role:admin`.
