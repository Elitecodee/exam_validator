# Exam Validator

Laravel-oriented implementation starter for validating exams against blueprint rules.

## Progress

### Phase 1
- Role-based authentication flow (Admin, Lecturer)
- Protected dashboard routing

### Phase 2A
- Admin blueprint management
- Blueprint CRUD + activate/deactivate
- Blueprint self-validation (sum/range checks)

### Phase 2B
- Lecturer exam creation
- Question entry per exam
- Real-time validation report against blueprint
- Final compliance check on submit (Pass/Fail + failed rule + suggestion)
- Validation history logging snapshots per submit attempt

### Phase 3
- Reporting module (analytics charts + exports)
- Chart-data JSON endpoints
- CSV exports (compliance + detailed distribution)
- Printable report page for PDF export

### Phase 4
- Admin approval/rejection workflow
- Submitted exam review queue
- Approve/reject endpoints with review notes
- Lecturer-visible rejection feedback for resubmission

## Implemented feature map

### Admin
- Blueprint settings:
  - create/edit/delete/toggle
  - configure total marks, type split, topic rules, difficulty rules, min/max limits

### Lecturer
- Create exam with selected blueprint
- Add questions with:
  - question text
  - type (theory/problem solving)
  - topic
  - difficulty
  - marks
- View live validation metrics:
  - expected vs current vs deviation
- Submit exam for final compliance check
- Locked editing for already-submitted exams

## Core logic

Validation computes percentages by marks:
- `percentage = category_marks / total_exam_marks * 100`

Then compares to blueprint limits:
- out of min/max => violation
- on submit, any violation => fail

Matching is normalized (trim + lowercase) so rule keys and question values compare safely (`Easy` == `easy`).

## Important files

- `app/Http/Controllers/Admin/BlueprintController.php`
- `app/Http/Controllers/Lecturer/ExamController.php`
- `app/Services/ExamValidationService.php`
- `app/Models/Blueprint.php`
- `app/Models/BlueprintRule.php`
- `app/Models/Exam.php`
- `app/Models/Question.php`
- `app/Models/ValidationHistory.php`
- `resources/views/admin/blueprints/*`
- `resources/views/lecturer/exams/*`
- `routes/web.php`

## Documentation
- `docs/admin-blueprint-management.md`
- `docs/phase-2-exam-creation-validation.md`
- `docs/admin-analytics-reporting.md`
- `docs/phase-3-reporting-module.md`
- `docs/phase-4-admin-approval-workflow.md`
