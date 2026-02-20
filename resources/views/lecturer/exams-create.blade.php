@extends('layouts.app', ['title' => 'Create Exam'])

@section('content')
<h1>Create Exam</h1>

<div class="card">
    <form method="POST" action="{{ route('lecturer.exams.store') }}">
        @csrf

        <label for="title">Exam Title</label>
        <input id="title" name="title" type="text" placeholder="e.g., Midterm Exam - MTH101" required>

        <label for="course_id">Course</label>
        <select id="course_id" name="course_id" required>
            <option value="">Select course</option>
        </select>

        <label for="blueprint_id">Blueprint</label>
        <select id="blueprint_id" name="blueprint_id" required>
            <option value="">Select active blueprint</option>
        </select>

        <button type="submit">Create Draft</button>
    </form>
</div>
@endsection
