# Phase 1 Pages (Setup + Role-Based Authentication)

## Public Pages

### Login Page
- URL: `/login`
- Purpose: Authenticate admin/lecturer
- Fields: email, password, remember me
- Action: POST `/login`
- Redirect:
  - Admin -> `/admin/dashboard`
  - Lecturer -> `/lecturer/dashboard`

### Register Page (Lecturer)
- URL: `/register`
- Purpose: Create lecturer account
- Fields: name, email, password, confirm password
- Action: POST `/register`
- Default role assigned: `lecturer`

## Admin Pages

### Admin Dashboard
- URL: `/admin/dashboard`
- Access: `auth + role:admin`
- Purpose:
  - See compliance KPIs
  - Navigate to blueprint and report modules

## Lecturer Pages

### Lecturer Dashboard
- URL: `/lecturer/dashboard`
- Access: `auth + role:lecturer`
- Purpose:
  - See draft/submitted exam stats
  - Jump to exam list

### Exams List Page
- URL: `/lecturer/exams`
- Access: `auth + role:lecturer`
- Purpose:
  - View own exams
  - Create new exam

### Create Exam Page
- URL: `/lecturer/exams/create`
- Access: `auth + role:lecturer`
- Purpose:
  - Select course
  - Select active blueprint
  - Create exam draft

### Exam Builder Page
- URL: `/lecturer/exams/{exam}`
- Access: `auth + role:lecturer`
- Purpose:
  - Add questions (text, type, topic, difficulty, marks)
  - See live compliance placeholders (to wire in Phase 2)

## Security Rules
- Unauthenticated users only access login/register.
- Admin pages blocked for lecturer users.
- Lecturer pages blocked for admin users unless intentionally shared.
- All dashboards require session authentication.
