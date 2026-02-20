@extends('layouts.app', ['title' => 'Create Exam'])

@section('content')
<h1 class="uni-page-title">Create Exam Draft</h1>
<p class="uni-subtitle">Select blueprint and initialize a new exam paper.</p>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('lecturer.exams.store') }}" class="row g-3">
            @csrf
            <div class="col-12">
                <label for="title" class="form-label">Exam Title</label>
                <input id="title" name="title" type="text" value="{{ old('title') }}" class="form-control" placeholder="e.g., Midterm Exam - MTH101" required>
            </div>
            <div class="col-md-4">
                <label for="course_id" class="form-label">Course ID</label>
                <input id="course_id" name="course_id" type="number" value="{{ old('course_id') }}" class="form-control">
            </div>
            <div class="col-md-8">
                <label for="blueprint_id" class="form-label">Active Blueprint</label>
                <select id="blueprint_id" name="blueprint_id" class="form-select" required>
                    <option value="">Select active blueprint</option>
                    @foreach ($blueprints as $blueprint)
                        <option value="{{ $blueprint->id }}" @selected(old('blueprint_id') == $blueprint->id)>{{ $blueprint->name }} ({{ $blueprint->total_marks }} marks)</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12"><button type="submit" class="btn btn-primary">Create Draft Exam</button></div>
        </form>
    </div>
</div>
@endsection
