@extends('layouts.app', ['title' => 'My Exams'])

@section('content')
<h1>My Exams</h1>
<p><a href="{{ route('lecturer.exams.create') }}">+ Create New Exam</a></p>

<div class="card">
    <p class="muted">No exams yet. Create one to begin.</p>
</div>
@endsection
