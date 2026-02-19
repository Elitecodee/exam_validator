@extends('layouts.app', ['title' => 'Admin Dashboard'])

@section('content')
<h1>Admin Dashboard</h1>
<p class="muted">Manage blueprint settings, monitor compliance, and review violations.</p>

<div class="grid">
    <div class="card"><strong>Total Blueprints</strong><br>{{ $stats['total_blueprints'] }}</div>
    <div class="card"><strong>Exam Submissions</strong><br>{{ $stats['exam_submissions'] }}</div>
    <div class="card"><strong>Compliance Rate</strong><br>{{ $stats['compliance_rate'] }}</div>
    <div class="card"><strong>Common Violation</strong><br>{{ $stats['common_violation'] }}</div>
</div>

<div class="card">
    <h3>Blueprint Management</h3>
    <p class="muted">Create, edit, delete, and activate/deactivate blueprint definitions.</p>
    <a href="{{ route('admin.blueprints.index') }}">Open Blueprint Settings</a>
</div>
@endsection
