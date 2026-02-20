@extends('layouts.app', ['title' => 'Exam Review Queue'])

@section('content')
<h1 class="uni-page-title">Exam Review Queue</h1>
<p class="uni-subtitle">Moderate submitted papers and finalize academic approval.</p>

<div class="card mb-3">
    <div class="card-body">
        <h2 class="h5 text-primary">Pending Submitted Exams</h2>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead><tr><th>Exam ID</th><th>Title</th><th>Lecturer ID</th><th>Questions</th><th>Submitted At</th><th>Action</th></tr></thead>
                <tbody>
                @forelse($submittedExams as $exam)
                    <tr>
                        <td>{{ $exam->id }}</td><td>{{ $exam->title }}</td><td>{{ $exam->lecturer_id ?? 'N/A' }}</td><td>{{ $exam->questions_count }}</td><td>{{ $exam->submitted_at }}</td>
                        <td><a class="btn btn-sm btn-primary" href="{{ route('admin.exams.show', $exam) }}">Review</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-secondary">No submitted exams waiting for review.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h2 class="h5 text-primary">Recently Reviewed</h2>
        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead><tr><th>Exam ID</th><th>Title</th><th>Status</th><th>Reviewed At</th><th>Note</th></tr></thead>
                <tbody>
                @forelse($reviewedExams as $exam)
                    <tr><td>{{ $exam->id }}</td><td>{{ $exam->title }}</td><td><span class="badge text-bg-secondary">{{ strtoupper($exam->status) }}</span></td><td>{{ $exam->reviewed_at }}</td><td>{{ $exam->review_note ?: '-' }}</td></tr>
                @empty
                    <tr><td colspan="5" class="text-secondary">No reviewed exams yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
