@extends('layouts.app', ['title' => 'Admin Dashboard'])

@section('content')
<h1>Admin Dashboard</h1>
<p class="muted">Monitor compliance KPIs and manage blueprint settings.</p>

<div class="grid">
    <div class="card"><strong>Total Blueprints</strong><br>{{ $kpis['total_blueprints'] }}</div>
    <div class="card"><strong>Total Exams</strong><br>{{ $kpis['total_exams'] }}</div>
    <div class="card"><strong>Total Validations</strong><br>{{ $kpis['total_validations'] }}</div>
    <div class="card"><strong>Overall Compliance Rate</strong><br>{{ $kpis['overall_compliance_rate'] }}%</div>
</div>

<div class="grid">
    <div class="card">
        <h3>Top Lecturer Compliance</h3>
        <table style="width:100%; border-collapse: collapse;">
            <thead>
            <tr>
                <th style="text-align:left; padding:6px;">Lecturer ID</th>
                <th style="text-align:left; padding:6px;">Attempts</th>
                <th style="text-align:left; padding:6px;">Passes</th>
                <th style="text-align:left; padding:6px;">Rate</th>
            </tr>
            </thead>
            <tbody>
            @forelse($top_lecturers as $row)
                <tr>
                    <td style="padding:6px;">{{ $row['lecturer_id'] ?? 'N/A' }}</td>
                    <td style="padding:6px;">{{ $row['attempts'] }}</td>
                    <td style="padding:6px;">{{ $row['passes'] }}</td>
                    <td style="padding:6px;">{{ $row['compliance_rate'] }}%</td>
                </tr>
            @empty
                <tr><td colspan="4" class="muted" style="padding:6px;">No validation data yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="card">
        <h3>Common Rule Violations</h3>
        <ul>
            @forelse($common_violations as $violation)
                <li>{{ $violation['rule'] }} - {{ $violation['count'] }} time(s)</li>
            @empty
                <li class="muted">No violations recorded yet.</li>
            @endforelse
        </ul>
    </div>
</div>

<div class="card">
    <a href="{{ route('admin.analytics.index') }}">Open full analytics</a>
    &nbsp;|&nbsp;
    <a href="{{ route('admin.reports.index') }}">Open reporting module</a>
    &nbsp;|&nbsp;
    <a href="{{ route('admin.reports.compliance.csv') }}">Download compliance CSV</a>
    &nbsp;|&nbsp;
    <a href="{{ route('admin.blueprints.index') }}">Open Blueprint Settings</a>
</div>
@endsection
