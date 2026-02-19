@extends('layouts.app', ['title' => 'Lecturer Dashboard'])

@section('content')
<h1>Lecturer Dashboard</h1>
<p class="muted">Create exams, add questions, and monitor compliance status.</p>

<div class="grid">
    <div class="card"><strong>Total Exams</strong><br>{{ $stats['total_exams'] }}</div>
    <div class="card"><strong>Draft Exams</strong><br>{{ $stats['draft_exams'] }}</div>
    <div class="card"><strong>Submitted Exams</strong><br>{{ $stats['submitted_exams'] }}</div>
    <div class="card"><strong>Last Status</strong><br>{{ $stats['last_status'] }}</div>
</div>

<div class="card">
    <a href="{{ route('lecturer.exams.index') }}">Go to My Exams</a>
</div>
@endsection
