@extends('layouts.app', ['title' => 'Admin Dashboard'])

@section('content')
<h1>Admin Dashboard</h1>
<p class="muted">Manage blueprints, monitor compliance, and review violations.</p>

<div class="grid">
    <div class="card"><strong>Total Blueprints</strong><br>{{ $stats['total_blueprints'] }}</div>
    <div class="card"><strong>Exam Submissions</strong><br>{{ $stats['exam_submissions'] }}</div>
    <div class="card"><strong>Compliance Rate</strong><br>{{ $stats['compliance_rate'] }}</div>
    <div class="card"><strong>Common Violation</strong><br>{{ $stats['common_violation'] }}</div>
</div>

<div class="card">
    <h3>Admin Pages (Phase 1 stubs)</h3>
    <ul>
        <li>Blueprint list/create/edit/delete/activate</li>
        <li>Tolerance settings</li>
        <li>Compliance reports export</li>
    </ul>
</div>
@endsection
