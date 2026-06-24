@extends('layouts.app', ['title' => 'Exam Builder'])

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-start mb-3">
    <div>
        <h1 class="uni-page-title mb-1">{{ $exam->title }}</h1>
        <p class="uni-subtitle mb-0">Blueprint: {{ $exam->blueprint?->name ?? 'N/A' }} | Status: {{ strtoupper($exam->status) }}</p>
    </div>
</div>

@if($exam->status === 'rejected')
    <div class="alert alert-warning"><strong>Review note:</strong> {{ $exam->review_note ?: 'Please update questions and resubmit.' }}</div>
@endif
@if ($errors->has('submit'))
    <div class="alert alert-danger">{{ $errors->first('submit') }}</div>
@endif

<div class="row g-3 mb-3">
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5 text-primary">Add Question</h2>
                @if ($exam->status !== 'draft')
                    <p class="text-secondary small">This exam is submitted and locked for editing.</p>
                @endif
                <form method="POST" action="{{ route('lecturer.exams.questions.store', $exam) }}" class="d-grid gap-2">
                    @csrf
                    <label class="form-label mb-0">Question Text</label>
                    <textarea name="question_text" rows="4" class="form-control" required @disabled($exam->status !== 'draft')>{{ old('question_text') }}</textarea>

                    <label class="form-label mb-0 mt-2">Question Type</label>
                    <select name="question_type" class="form-select" required @disabled($exam->status !== 'draft')>
                        <option value="theory">Theory</option>
                        <option value="problem_solving">Problem Solving</option>
                    </select>

                    <label class="form-label mb-0 mt-2">Topic</label>
                    <input name="topic" type="text" value="{{ old('topic') }}" class="form-control" placeholder="Algebra" required @disabled($exam->status !== 'draft')>

                    <label class="form-label mb-0 mt-2">Difficulty</label>
                    <select name="difficulty" class="form-select" required @disabled($exam->status !== 'draft')>
                        <option value="easy">Easy</option><option value="medium">Medium</option><option value="hard">Hard</option>
                    </select>

                    <label class="form-label mb-0 mt-2">Marks</label>
                    <input name="marks" type="number" step="0.5" min="0.5" value="{{ old('marks') }}" class="form-control" required @disabled($exam->status !== 'draft')>

                    <button type="submit" class="btn btn-primary mt-2" @disabled($exam->status !== 'draft')>Add Question</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5 text-primary">Real-Time Validation Summary</h2>
                <p><strong>Total Marks:</strong> {{ $report['total_marks_current'] }} / {{ $report['total_marks_expected'] }}</p>

                @foreach (['type' => 'Question Type', 'topic' => 'Topic', 'difficulty' => 'Difficulty'] as $sectionKey => $title)
                    <h3 class="h6 text-secondary mt-3">{{ $title }}</h3>
                    <div class="table-responsive">
                        <table class="table table-sm align-middle">
                            <thead><tr><th>Rule</th><th>Expected</th><th>Current</th><th>Deviation</th><th>Status</th></tr></thead>
                            <tbody>
                            @foreach ($report['sections'][$sectionKey] as $row)
                                <tr>
                                    <td>{{ $row['rule_key'] }}</td>
                                    <td>{{ $row['expected_percentage'] }}%</td>
                                    <td>{{ $row['current_percentage'] }}%</td>
                                    <td>{{ $row['deviation_percentage'] }}%</td>
                                    <td>{{ $row['status'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach

                <form method="POST" action="{{ route('lecturer.exams.submit', $exam) }}">
                    @csrf
                    <button type="submit" class="btn {{ $report['passed'] ? 'btn-success' : 'btn-danger' }}" @disabled($exam->status !== 'draft')>
                        Submit for Final Compliance Check
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <h2 class="h5 text-primary">Questions</h2>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead><tr><th>Text</th><th>Type</th><th>Topic</th><th>Difficulty</th><th>Marks</th></tr></thead>
                <tbody>
                    @forelse ($exam->questions as $question)
                        <tr><td>{{ $question->question_text }}</td><td>{{ $question->question_type }}</td><td>{{ $question->topic }}</td><td>{{ $question->difficulty }}</td><td>{{ $question->marks }}</td></tr>
                    @empty
                        <tr><td colspan="5" class="text-secondary">No questions added yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card border-{{ $report['passed'] ? 'success' : 'danger' }}">
    <div class="card-body">
        <h2 class="h5 text-{{ $report['passed'] ? 'success' : 'danger' }}">Final Compliance Report (Current)</h2>
        <p><strong>Result:</strong> {{ strtoupper($report['summary']) }}</p>
        @if (!$report['passed'])
            <ul class="mb-0">
                @foreach ($report['violations'] as $violation)
                    <li><strong>{{ $violation['rule'] }}</strong> - {{ $violation['message'] }} <span class="text-secondary">(Suggestion: {{ $violation['suggestion'] }})</span></li>
                @endforeach
            </ul>
        @else
            <p class="text-secondary mb-0">All rules are within configured ranges.</p>
        @endif
    </div>
</div>
@endsection
