@extends('layouts.app', ['title' => 'Create Exam'])

@section('content')
<div class="d-flex flex-column flex-lg-row justify-content-between gap-3 align-items-lg-center mb-4">
    <div>
        <h1 class="uni-page-title mb-1">Create Exam Draft</h1>
        <p class="uni-subtitle mb-0">Select one active blueprint, then build the exam questions against its rules.</p>
    </div>
    <span class="badge text-bg-light border align-self-start align-self-lg-center">{{ $blueprints->count() }} active blueprint{{ $blueprints->count() === 1 ? '' : 's' }}</span>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

@if ($blueprints->isEmpty())
    <div class="alert alert-warning shadow-sm">
        <h2 class="h5 mb-2">No active blueprint is available yet</h2>
        <p class="mb-1">An exam draft must be attached to an active blueprint before questions can be validated.</p>
        <p class="mb-0">
            @if ($totalBlueprints > 0)
                Ask an admin to activate one of the existing blueprints from <strong>Admin &gt; Blueprint Settings</strong>.
            @else
                Ask an admin to create the first blueprint from <strong>Admin &gt; Blueprint Settings</strong>.
            @endif
        </p>
    </div>
@endif

<div class="card mb-4">
    <div class="card-body">
        <form method="POST" action="{{ route('lecturer.exams.store') }}" class="row g-3">
            @csrf
            <div class="col-12">
                <label for="title" class="form-label">Exam Title</label>
                <input id="title" name="title" type="text" value="{{ old('title') }}" class="form-control" placeholder="e.g., Midterm Exam - MTH101" required>
            </div>
            <div class="col-md-4">
                <label for="course_id" class="form-label">Course ID</label>
                <input id="course_id" name="course_id" type="number" value="{{ old('course_id') }}" class="form-control" placeholder="Optional numeric course ID">
                <div class="form-text">Use the same course ID that the admin used for the blueprint, if applicable.</div>
            </div>
            <div class="col-md-8">
                <label for="blueprint_id" class="form-label">Active Blueprint</label>
                <select id="blueprint_id" name="blueprint_id" class="form-select" required @disabled($blueprints->isEmpty())>
                    <option value="">{{ $blueprints->isEmpty() ? 'No active blueprints available' : 'Select active blueprint' }}</option>
                    @foreach ($blueprints as $blueprint)
                        <option value="{{ $blueprint->id }}" @selected(old('blueprint_id') == $blueprint->id)>
                            {{ $blueprint->name }} — {{ $blueprint->total_marks }} marks, ±{{ $blueprint->tolerance_percentage }}% tolerance
                        </option>
                    @endforeach
                </select>
                <div class="form-text">Only active blueprints are shown here because inactive blueprints cannot be used for new drafts.</div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary" @disabled($blueprints->isEmpty())>Create Draft Exam</button>
            </div>
        </form>
    </div>
</div>

@if ($blueprints->isNotEmpty())
    <h2 class="h5 mb-3">Available active blueprints</h2>
    <div class="row g-3">
        @foreach ($blueprints as $blueprint)
            @php
                $topicRules = $blueprint->rules->where('rule_type', 'topic');
                $difficultyRules = $blueprint->rules->where('rule_type', 'difficulty');
            @endphp
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between gap-3 mb-2">
                            <h3 class="h5 mb-0">{{ $blueprint->name }}</h3>
                            <span class="badge text-bg-success">Active</span>
                        </div>
                        <p class="text-muted mb-3">{{ $blueprint->total_marks }} total marks · Theory {{ $blueprint->theory_percentage }}% · Problem solving {{ $blueprint->problem_solving_percentage }}% · ±{{ $blueprint->tolerance_percentage }}%</p>

                        <div class="row g-3 small">
                            <div class="col-md-6">
                                <strong class="d-block mb-1">Topics</strong>
                                @forelse ($topicRules as $rule)
                                    <div class="d-flex justify-content-between border-bottom py-1">
                                        <span>{{ $rule->rule_key }}</span>
                                        <span>{{ $rule->expected_percentage }}%</span>
                                    </div>
                                @empty
                                    <span class="text-muted">No topic rules saved.</span>
                                @endforelse
                            </div>
                            <div class="col-md-6">
                                <strong class="d-block mb-1">Difficulty</strong>
                                @forelse ($difficultyRules as $rule)
                                    <div class="d-flex justify-content-between border-bottom py-1">
                                        <span>{{ ucfirst($rule->rule_key) }}</span>
                                        <span>{{ $rule->expected_percentage }}%</span>
                                    </div>
                                @empty
                                    <span class="text-muted">No difficulty rules saved.</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
