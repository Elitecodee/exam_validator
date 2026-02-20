@extends('layouts.app', ['title' => 'Exam Review Queue'])

@section('content')
<h1>Admin Exam Review Queue</h1>
<p class="muted">Review submitted exams and decide approve/reject.</p>

<div class="card">
    <h3>Pending Submitted Exams</h3>
    <table style="width:100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="text-align:left; padding:6px;">Exam ID</th>
                <th style="text-align:left; padding:6px;">Title</th>
                <th style="text-align:left; padding:6px;">Lecturer ID</th>
                <th style="text-align:left; padding:6px;">Questions</th>
                <th style="text-align:left; padding:6px;">Submitted At</th>
                <th style="text-align:left; padding:6px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($submittedExams as $exam)
                <tr>
                    <td style="padding:6px;">{{ $exam->id }}</td>
                    <td style="padding:6px;">{{ $exam->title }}</td>
                    <td style="padding:6px;">{{ $exam->lecturer_id ?? 'N/A' }}</td>
                    <td style="padding:6px;">{{ $exam->questions_count }}</td>
                    <td style="padding:6px;">{{ $exam->submitted_at }}</td>
                    <td style="padding:6px;"><a href="{{ route('admin.exams.show', $exam) }}">Review</a></td>
                </tr>
            @empty
                <tr><td colspan="6" class="muted" style="padding:6px;">No submitted exams waiting for review.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="card">
    <h3>Recently Reviewed</h3>
    <table style="width:100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="text-align:left; padding:6px;">Exam ID</th>
                <th style="text-align:left; padding:6px;">Title</th>
                <th style="text-align:left; padding:6px;">Status</th>
                <th style="text-align:left; padding:6px;">Reviewed At</th>
                <th style="text-align:left; padding:6px;">Note</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reviewedExams as $exam)
                <tr>
                    <td style="padding:6px;">{{ $exam->id }}</td>
                    <td style="padding:6px;">{{ $exam->title }}</td>
                    <td style="padding:6px;">{{ strtoupper($exam->status) }}</td>
                    <td style="padding:6px;">{{ $exam->reviewed_at }}</td>
                    <td style="padding:6px;">{{ $exam->review_note ?: '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="muted" style="padding:6px;">No reviewed exams yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
