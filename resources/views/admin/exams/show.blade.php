@extends('layouts.app', ['title' => 'Review Exam'])

@section('content')
<h1 class="uni-page-title">Review Exam #{{ $exam->id }}</h1>
<p class="uni-subtitle">{{ $exam->title }} | Lecturer: {{ $exam->lecturer_id ?? 'N/A' }} | Status: {{ strtoupper($exam->status) }}</p>

@if ($errors->any())
<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

<div class="card mb-3"><div class="card-body">
    <h2 class="h5 text-primary">Compliance Snapshot</h2>
    <p><strong>Result:</strong> {{ strtoupper($report['summary']) }}</p>
    <p><strong>Total Marks:</strong> {{ $report['total_marks_current'] }} / {{ $report['total_marks_expected'] }}</p>
    @if(!$report['passed'])
        <ul class="mb-0">@foreach($report['violations'] as $v)<li><strong>{{ $v['rule'] }}</strong>: {{ $v['message'] }} <span class="text-secondary">({{ $v['suggestion'] }})</span></li>@endforeach</ul>
    @endif
</div></div>

<div class="card mb-3"><div class="card-body">
    <h2 class="h5 text-primary">Question Paper</h2>
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead><tr><th>Text</th><th>Type</th><th>Topic</th><th>Difficulty</th><th>Marks</th></tr></thead>
            <tbody>
            @forelse($exam->questions as $q)
                <tr><td>{{ $q->question_text }}</td><td>{{ $q->question_type }}</td><td>{{ $q->topic }}</td><td>{{ $q->difficulty }}</td><td>{{ $q->marks }}</td></tr>
            @empty
                <tr><td colspan="5" class="text-secondary">No questions available.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div></div>

@if($exam->status === 'submitted')
<div class="row g-3">
    <div class="col-lg-6">
        <div class="card"><div class="card-body">
            <h3 class="h6 text-success">Approve</h3>
            <form method="POST" action="{{ route('admin.exams.approve', $exam) }}">@csrf @method('PATCH')
                <label class="form-label">Optional note</label>
                <textarea name="review_note" rows="3" class="form-control mb-2"></textarea>
                <button type="submit" class="btn btn-success">Approve Exam</button>
            </form>
        </div></div>
    </div>
    <div class="col-lg-6">
        <div class="card"><div class="card-body">
            <h3 class="h6 text-danger">Reject</h3>
            <form method="POST" action="{{ route('admin.exams.reject', $exam) }}">@csrf @method('PATCH')
                <label class="form-label">Rejection feedback (required)</label>
                <textarea name="review_note" rows="4" class="form-control mb-2" required></textarea>
                <button type="submit" class="btn btn-danger">Reject Exam</button>
            </form>
        </div></div>
    </div>
</div>
@else
<div class="alert alert-secondary"><strong>Review completed:</strong> {{ strtoupper($exam->status) }}. Note: {{ $exam->review_note ?: 'No note provided' }}</div>
@endif
@endsection
