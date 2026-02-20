@extends('layouts.app', ['title' => 'My Exams'])

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h1 class="uni-page-title mb-1">My Exams</h1>
        <p class="uni-subtitle mb-0">Manage drafts, monitor compliance, and submit for review.</p>
    </div>
    <a href="{{ route('lecturer.exams.create') }}" class="btn btn-primary">+ Create New Exam</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead><tr><th>Title</th><th>Status</th><th>Questions</th><th>Action</th></tr></thead>
                <tbody>
                @forelse ($exams as $exam)
                    <tr>
                        <td>{{ $exam->title }}</td>
                        <td><span class="badge text-bg-light border">{{ strtoupper($exam->status) }}</span></td>
                        <td>{{ $exam->questions_count }}</td>
                        <td><a class="btn btn-sm btn-outline-primary" href="{{ route('lecturer.exams.show', $exam) }}">Open</a></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-secondary">No exams created yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
