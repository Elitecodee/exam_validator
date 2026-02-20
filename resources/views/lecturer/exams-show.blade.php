@extends('layouts.app', ['title' => 'Exam Builder'])

@section('content')
<h1>Exam Builder #{{ $examId }}</h1>
<p class="muted">Add questions and track real-time blueprint compliance.</p>

<div class="card">
    <h3>Add Question (Phase 2 implementation target)</h3>
    <form>
        <label>Question Text</label>
        <textarea rows="4" placeholder="Enter question text"></textarea>

        <label>Question Type</label>
        <select><option>Theory</option><option>Problem Solving</option></select>

        <label>Topic</label>
        <input type="text" placeholder="Algebra / Calculus / Statistics">

        <label>Difficulty</label>
        <select><option>Easy</option><option>Medium</option><option>Hard</option></select>

        <label>Marks</label>
        <input type="number" step="0.5" min="0">

        <button type="button">Add Question</button>
    </form>
</div>

<div class="grid">
    <div class="card">
        <h4>Current Distribution</h4>
        <p class="muted">Theory: --%</p>
        <p class="muted">Problem Solving: --%</p>
    </div>
    <div class="card">
        <h4>Validation Status</h4>
        <p class="muted">No validation run yet.</p>
    </div>
</div>
@endsection
