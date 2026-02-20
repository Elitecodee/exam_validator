@extends('layouts.app', ['title' => 'My Exams'])

@section('content')
<h1>My Exams</h1>
<p><a href="{{ route('lecturer.exams.create') }}">+ Create New Exam</a></p>

<div class="card">
    <table style="width:100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="text-align:left; padding: 8px;">Title</th>
                <th style="text-align:left; padding: 8px;">Status</th>
                <th style="text-align:left; padding: 8px;">Questions</th>
                <th style="text-align:left; padding: 8px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($exams as $exam)
                <tr>
                    <td style="padding: 8px;">{{ $exam->title }}</td>
                    <td style="padding: 8px;">{{ strtoupper($exam->status) }}</td>
                    <td style="padding: 8px;">{{ $exam->questions_count }}</td>
                    <td style="padding: 8px;"><a href="{{ route('lecturer.exams.show', $exam) }}">Open</a></td>
                </tr>
            @empty
                <tr><td colspan="4" style="padding: 8px;" class="muted">No exams created yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
