@extends('layouts.app', ['title' => 'Admin Dashboard'])

@section('content')
<h1 class="uni-page-title">Admin Dashboard</h1>
<p class="uni-subtitle">Academic quality intelligence for blueprint compliance and exam governance.</p>

<div class="row g-3 mb-3">
    <div class="col-md-3"><div class="card"><div class="card-body"><div class="text-secondary small">Total Blueprints</div><div class="uni-kpi">{{ $kpis['total_blueprints'] }}</div></div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body"><div class="text-secondary small">Total Exams</div><div class="uni-kpi">{{ $kpis['total_exams'] }}</div></div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body"><div class="text-secondary small">Total Validations</div><div class="uni-kpi">{{ $kpis['total_validations'] }}</div></div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body"><div class="text-secondary small">Overall Compliance</div><div class="uni-kpi">{{ $kpis['overall_compliance_rate'] }}%</div></div></div></div>
</div>

<div class="row g-3 mb-3">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                <h2 class="h5 text-primary">Top Lecturer Compliance</h2>
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead><tr><th>Lecturer ID</th><th>Attempts</th><th>Passes</th><th>Rate</th></tr></thead>
                        <tbody>
                        @forelse($top_lecturers as $row)
                            <tr><td>{{ $row['lecturer_id'] ?? 'N/A' }}</td><td>{{ $row['attempts'] }}</td><td>{{ $row['passes'] }}</td><td>{{ $row['compliance_rate'] }}%</td></tr>
                        @empty
                            <tr><td colspan="4" class="text-secondary">No validation data yet.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5 text-primary">Common Rule Violations</h2>
                <ul class="mb-0">
                    @forelse($common_violations as $violation)
                        <li>{{ $violation['rule'] }} <span class="text-secondary">({{ $violation['count'] }}x)</span></li>
                    @empty
                        <li class="text-secondary">No violations recorded yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body d-flex flex-wrap gap-2">
        <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.analytics.index') }}">Full Analytics</a>
        <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.reports.index') }}">Reporting Module</a>
        <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.reports.compliance.csv') }}">Compliance CSV</a>
        <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.blueprints.index') }}">Blueprint Settings</a>
        <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.exams.index') }}">Exam Review Queue</a>
    </div>
</div>
@endsection
