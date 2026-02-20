@extends('layouts.app', ['title' => 'Reporting Module'])

@section('content')
<h1 class="uni-page-title">Reporting Module</h1>
<p class="uni-subtitle">Publication-ready academic compliance reports, distribution snapshots, and charts.</p>

<div class="row g-3 mb-3">
    <div class="col-md-6"><div class="card"><div class="card-body"><small class="text-secondary">Overall Compliance</small><div class="uni-kpi">{{ $analytics['kpis']['overall_compliance_rate'] }}%</div></div></div></div>
    <div class="col-md-6"><div class="card"><div class="card-body"><small class="text-secondary">Total Validations</small><div class="uni-kpi">{{ $analytics['kpis']['total_validations'] }}</div></div></div></div>
</div>

<div class="card mb-3"><div class="card-body"><h2 class="h5 text-primary">Compliance by Lecturer (Chart-ready)</h2><canvas id="lecturerChart" height="130"></canvas></div></div>
<div class="card mb-3"><div class="card-body"><h2 class="h5 text-primary">Common Violations (Chart-ready)</h2><canvas id="violationChart" height="130"></canvas></div></div>

<div class="card">
    <div class="card-body d-flex flex-wrap gap-2">
        <a class="btn btn-primary" href="{{ route('admin.reports.compliance.csv') }}">Compliance Summary CSV</a>
        <a class="btn btn-outline-primary" href="{{ route('admin.reports.distribution.csv') }}">Detailed Breakdown CSV</a>
        <a class="btn btn-outline-secondary" href="{{ route('admin.reports.printable') }}" target="_blank">Printable Report (Save PDF)</a>
    </div>
</div>

<script>
async function loadChartData() {
    const response = await fetch("{{ route('admin.reports.chart-data') }}");
    const data = await response.json();

    const lecturerCtx = document.getElementById('lecturerChart').getContext('2d');
    lecturerCtx.clearRect(0, 0, 1200, 130);
    lecturerCtx.fillStyle = '#0f3d7a';
    lecturerCtx.font = '14px Arial';
    data.lecturer_labels.forEach((label, index) => {
        const value = data.lecturer_compliance_values[index] || 0;
        lecturerCtx.fillText(`${label}: ${value}%`, 12, 25 + (index * 20));
    });

    const violationCtx = document.getElementById('violationChart').getContext('2d');
    violationCtx.clearRect(0, 0, 1200, 130);
    violationCtx.fillStyle = '#0f3d7a';
    violationCtx.font = '14px Arial';
    data.violation_labels.forEach((label, index) => {
        const value = data.violation_counts[index] || 0;
        violationCtx.fillText(`${label}: ${value}`, 12, 25 + (index * 20));
    });
}
loadChartData();
</script>
@endsection
