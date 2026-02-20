@extends('layouts.app', ['title' => 'Admin Analytics'])

@section('content')
<h1 class="uni-page-title">Advanced Analytics</h1>
<p class="uni-subtitle">Department-level compliance trends and violation intelligence.</p>

<div class="row g-3 mb-3">
    <div class="col-md-3"><div class="card"><div class="card-body"><small class="text-secondary">Total Blueprints</small><div class="uni-kpi">{{ $analytics['kpis']['total_blueprints'] }}</div></div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body"><small class="text-secondary">Total Exams</small><div class="uni-kpi">{{ $analytics['kpis']['total_exams'] }}</div></div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body"><small class="text-secondary">Total Validations</small><div class="uni-kpi">{{ $analytics['kpis']['total_validations'] }}</div></div></div></div>
    <div class="col-md-3"><div class="card"><div class="card-body"><small class="text-secondary">Overall Compliance</small><div class="uni-kpi">{{ $analytics['kpis']['overall_compliance_rate'] }}%</div></div></div></div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <h2 class="h5 text-primary">Compliance by Lecturer</h2>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead><tr><th>Lecturer ID</th><th>Attempts</th><th>Passes</th><th>Fails</th><th>Compliance Rate</th></tr></thead>
                <tbody>
                    @forelse ($analytics['lecturer_compliance'] as $row)
                        <tr><td>{{ $row['lecturer_id'] ?? 'N/A' }}</td><td>{{ $row['attempts'] }}</td><td>{{ $row['passes'] }}</td><td>{{ $row['fails'] }}</td><td><span class="badge text-bg-primary">{{ $row['compliance_rate'] }}%</span></td></tr>
                    @empty
                        <tr><td colspan="5" class="text-secondary">No lecturer validation data yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <h2 class="h5 text-primary">Most Common Rule Violations</h2>
        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead><tr><th>Rule</th><th>Count</th></tr></thead>
                <tbody>
                    @forelse ($analytics['common_violations'] as $row)
                        <tr><td>{{ $row['rule'] }}</td><td>{{ $row['count'] }}</td></tr>
                    @empty
                        <tr><td colspan="2" class="text-secondary">No violations recorded.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<a href="{{ route('admin.reports.compliance.csv') }}" class="btn btn-primary">Download Compliance CSV</a>
@endsection
