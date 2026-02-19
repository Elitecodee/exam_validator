@extends('layouts.app', ['title' => 'Exam Builder'])

@section('content')
<h1>{{ $exam->title }}</h1>
<p class="muted">Blueprint: {{ $exam->blueprint?->name ?? 'N/A' }} | Status: {{ strtoupper($exam->status) }}</p>

@if ($errors->has('submit'))
    <div class="card" style="border: 1px solid #ef4444;">
        {{ $errors->first('submit') }}
    </div>
@endif

<div class="grid">
    <div class="card">
        <h3>Add Question</h3>
        <form method="POST" action="{{ route('lecturer.exams.questions.store', $exam) }}">
            @csrf

            <label for="question_text">Question Text</label>
            <textarea id="question_text" name="question_text" rows="4" required>{{ old('question_text') }}</textarea>

            <label for="question_type">Question Type</label>
            <select id="question_type" name="question_type" required>
                <option value="theory">Theory</option>
                <option value="problem_solving">Problem Solving</option>
            </select>

            <label for="topic">Topic</label>
            <input id="topic" name="topic" type="text" value="{{ old('topic') }}" placeholder="Algebra" required>

            <label for="difficulty">Difficulty</label>
            <select id="difficulty" name="difficulty" required>
                <option value="easy">Easy</option>
                <option value="medium">Medium</option>
                <option value="hard">Hard</option>
            </select>

            <label for="marks">Marks</label>
            <input id="marks" name="marks" type="number" step="0.5" min="0.5" value="{{ old('marks') }}" required>

            <button type="submit">Add Question</button>
        </form>
    </div>

    <div class="card">
        <h3>Real-Time Validation Summary</h3>
        <p><strong>Total Marks:</strong> {{ $report['total_marks_current'] }} / {{ $report['total_marks_expected'] }}</p>

        @foreach (['type' => 'Question Type', 'topic' => 'Topic', 'difficulty' => 'Difficulty'] as $sectionKey => $title)
            <h4>{{ $title }}</h4>
            <table style="width:100%; border-collapse: collapse; margin-bottom: 12px;">
                <thead>
                    <tr>
                        <th style="text-align:left; padding:4px;">Rule</th>
                        <th style="text-align:left; padding:4px;">Expected</th>
                        <th style="text-align:left; padding:4px;">Current</th>
                        <th style="text-align:left; padding:4px;">Deviation</th>
                        <th style="text-align:left; padding:4px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($report['sections'][$sectionKey] as $row)
                        <tr>
                            <td style="padding:4px;">{{ $row['rule_key'] }}</td>
                            <td style="padding:4px;">{{ $row['expected_percentage'] }}%</td>
                            <td style="padding:4px;">{{ $row['current_percentage'] }}%</td>
                            <td style="padding:4px;">{{ $row['deviation_percentage'] }}%</td>
                            <td style="padding:4px;">{{ $row['status'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach

        <form method="POST" action="{{ route('lecturer.exams.submit', $exam) }}">
            @csrf
            <button type="submit" style="background: {{ $report['passed'] ? '#059669' : '#dc2626' }};">
                Submit for Final Compliance Check
            </button>
        </form>
    </div>
</div>

<div class="card">
    <h3>Questions</h3>
    <table style="width:100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="text-align:left; padding: 6px;">Text</th>
                <th style="text-align:left; padding: 6px;">Type</th>
                <th style="text-align:left; padding: 6px;">Topic</th>
                <th style="text-align:left; padding: 6px;">Difficulty</th>
                <th style="text-align:left; padding: 6px;">Marks</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($exam->questions as $question)
                <tr>
                    <td style="padding: 6px;">{{ $question->question_text }}</td>
                    <td style="padding: 6px;">{{ $question->question_type }}</td>
                    <td style="padding: 6px;">{{ $question->topic }}</td>
                    <td style="padding: 6px;">{{ $question->difficulty }}</td>
                    <td style="padding: 6px;">{{ $question->marks }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="muted" style="padding:6px;">No questions added yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@if (!$report['passed'])
    <div class="card" style="border: 1px solid #ef4444;">
        <h3>Final Compliance Report (Current)</h3>
        <p><strong>Result:</strong> FAIL</p>
        <ul>
            @foreach ($report['violations'] as $violation)
                <li>
                    <strong>{{ $violation['rule'] }}</strong> - {{ $violation['message'] }}<br>
                    <span class="muted">Suggestion: {{ $violation['suggestion'] }}</span>
                </li>
            @endforeach
        </ul>
    </div>
@else
    <div class="card" style="border: 1px solid #10b981;">
        <h3>Final Compliance Report (Current)</h3>
        <p><strong>Result:</strong> PASS</p>
        <p class="muted">All rules are within configured ranges.</p>
    </div>
@endif
@endsection
