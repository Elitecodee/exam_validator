@extends('layouts.app', ['title' => 'Lecturer Dashboard'])

@section('content')
<h1 class="uni-page-title">Lecturer Dashboard</h1>
<p class="uni-subtitle">Prepare exam papers aligned with approved academic blueprints.</p>

<div class="row g-3 mb-3">
    <div class="col-md-3"><div class="card"><div class="card-body"><small class="text-secondary">Total Exams</small><div class="uni-kpi">{{ $stats['total_exams'] }}</div></div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body"><small class="text-secondary">Draft Exams</small><div class="uni-kpi">{{ $stats['draft_exams'] }}</div></div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body"><small class="text-secondary">Submitted Exams</small><div class="uni-kpi">{{ $stats['submitted_exams'] }}</div></div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body"><small class="text-secondary">Latest Status</small><div class="uni-kpi" style="font-size:1.05rem;">{{ $stats['last_status'] }}</div></div></div></div>
</div>

<a href="{{ route('lecturer.exams.index') }}" class="btn btn-primary">Open Exam Workspace</a>
@endsection
