@extends('layouts.app', ['title' => 'Create Exam'])

@section('content')
<h1>Create Exam</h1>

@if ($errors->any())
    <div class="card" style="border: 1px solid #ef4444;">
        <strong>Please fix the following:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <form method="POST" action="{{ route('lecturer.exams.store') }}">
        @csrf

        <label for="title">Exam Title</label>
        <input id="title" name="title" type="text" value="{{ old('title') }}" placeholder="e.g., Midterm Exam - MTH101" required>

        <label for="course_id">Course ID (optional placeholder)</label>
        <input id="course_id" name="course_id" type="number" value="{{ old('course_id') }}">

        <label for="blueprint_id">Active Blueprint</label>
        <select id="blueprint_id" name="blueprint_id" required>
            <option value="">Select active blueprint</option>
            @foreach ($blueprints as $blueprint)
                <option value="{{ $blueprint->id }}" @selected(old('blueprint_id') == $blueprint->id)>
                    {{ $blueprint->name }} ({{ $blueprint->total_marks }} marks)
                </option>
            @endforeach
        </select>

        <button type="submit">Create Draft Exam</button>
    </form>
</div>
@endsection
