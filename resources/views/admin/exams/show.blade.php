@extends('layouts.app', ['title' => 'Review Exam'])

@section('content')
<h1>Review Exam #{{ $exam->id }}</h1>
<p class="muted">{{ $exam->title }} | Lecturer: {{ $exam->lecturer_id ?? 'N/A' }} | Status: {{ strtoupper($exam->status) }}</p>

@if ($errors->any())
    <div class="card" style="border: 1px solid #ef4444;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <h3>Compliance Snapshot</h3>
    <p><strong>Result:</strong> {{ $report['summary'] }}</p>
    <p><strong>Total Marks:</strong> {{ $report['total_marks_current'] }} / {{ $report['total_marks_expected'] }}</p>

    @if(!$report['passed'])
        <ul>
            @foreach($report['violations'] as $v)
                <li><strong>{{ $v['rule'] }}</strong>: {{ $v['message'] }}<br><span class="muted">Suggestion: {{ $v['suggestion'] }}</span></li>
            @endforeach
        </ul>
    @endif
</div>

<div class="card">
    <h3>Questions</h3>
    <table style="width:100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="text-align:left; padding:6px;">Text</th>
                <th style="text-align:left; padding:6px;">Type</th>
                <th style="text-align:left; padding:6px;">Topic</th>
                <th style="text-align:left; padding:6px;">Difficulty</th>
                <th style="text-align:left; padding:6px;">Marks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($exam->questions as $q)
                <tr>
                    <td style="padding:6px;">{{ $q->question_text }}</td>
                    <td style="padding:6px;">{{ $q->question_type }}</td>
                    <td style="padding:6px;">{{ $q->topic }}</td>
                    <td style="padding:6px;">{{ $q->difficulty }}</td>
                    <td style="padding:6px;">{{ $q->marks }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if($exam->status === 'submitted')
<div class="grid">
    <div class="card">
        <h3>Approve</h3>
        <form method="POST" action="{{ route('admin.exams.approve', $exam) }}">
            @csrf
            @method('PATCH')
            <label for="review_note_approve">Optional note</label>
            <textarea id="review_note_approve" name="review_note" rows="3"></textarea>
            <button type="submit" style="background:#059669;">Approve Exam</button>
        </form>
    </div>

    <div class="card">
        <h3>Reject</h3>
        <form method="POST" action="{{ route('admin.exams.reject', $exam) }}">
            @csrf
            @method('PATCH')
            <label for="review_note_reject">Rejection feedback (required)</label>
            <textarea id="review_note_reject" name="review_note" rows="4" required></textarea>
            <button type="submit" style="background:#dc2626;">Reject Exam</button>
        </form>
    </div>
</div>
@else
<div class="card">
    <strong>Review completed:</strong> {{ strtoupper($exam->status) }}<br>
    <span class="muted">Review note: {{ $exam->review_note ?: 'No note provided' }}</span>
</div>
@endif
@endsection
