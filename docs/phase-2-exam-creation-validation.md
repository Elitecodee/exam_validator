# Phase 2: Exam Creation + Real-Time Validation + Final Compliance Check

## Implemented lecturer capabilities

- Create new exam draft
- Select course (placeholder ID for now)
- Select active blueprint
- Add questions to an exam

Each question stores:
- question text
- question type (`theory`, `problem_solving`)
- topic
- difficulty (`easy`, `medium`, `hard`)
- marks

## Real-time validation logic

Whenever exam builder is opened (and after each question add), system computes:
- total marks
- type distribution percentages
- topic distribution percentages
- difficulty distribution percentages

Then compares each computed percentage against blueprint rules (`expected`, `min`, `max`) and shows:
- expected percentage
- current percentage
- deviation percentage
- status (`Within allowed range`, `Exceeded by ...`, `Below by ...`)

## Final compliance check

Submit action runs full validation and:
- checks total exam marks match blueprint total marks
- checks each rule is within allowed range

If violations exist:
- exam remains `draft`
- report returns `FAIL`
- each failure includes rule, message, suggestion

If no violations:
- exam status becomes `submitted`
- `submitted_at` is set
- report returns `PASS`

## Key files

- `app/Http/Controllers/Lecturer/ExamController.php`
- `app/Services/ExamValidationService.php`
- `app/Models/Exam.php`
- `app/Models/Question.php`
- `resources/views/lecturer/exams/create.blade.php`
- `resources/views/lecturer/exams/index.blade.php`
- `resources/views/lecturer/exams/show.blade.php`
- `database/migrations/2026_01_01_000004_create_exams_table.php`
- `database/migrations/2026_01_01_000005_create_questions_table.php`
