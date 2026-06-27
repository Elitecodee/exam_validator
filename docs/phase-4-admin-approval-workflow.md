# Phase 4: Admin Approval/Rejection Workflow

## What is now implemented

Admin can now:
- View queue of submitted exams waiting for review
- Open a review page per submitted exam
- See compliance snapshot + question list
- Approve exam
- Reject exam with mandatory feedback

## State transitions

- `submitted` -> `approved`
- `submitted` -> `rejected`

Review metadata saved on exam:
- `reviewed_by`
- `reviewed_at`
- `review_note`

## Routes

- `GET /admin/exams/review`
- `GET /admin/exams/{exam}/review`
- `PATCH /admin/exams/{exam}/approve`
- `PATCH /admin/exams/{exam}/reject`

All protected by `auth` + `role:admin`.

## Lecturer experience

If exam is rejected, lecturer sees the rejection review note in the exam builder page and can edit/resubmit.
