@extends('layouts.app', ['title' => 'Reporting Module'])

@section('content')
<h1>Reporting Module</h1>
<p class="muted">Compliance summary, distribution charts, and exports.</p>

<div class="grid">
    <div class="card"><strong>Overall Compliance</strong><br>{{ $analytics['kpis']['overall_compliance_rate'] }}%</div>
    <div class="card"><strong>Total Validations</strong><br>{{ $analytics['kpis']['total_validations'] }}</div>
</div>

<div class="card">
    <h3>Compliance by Lecturer (Chart-ready)</h3>
    <canvas id="lecturerChart" height="120"></canvas>
</div>

<div class="card">
    <h3>Common Violations (Chart-ready)</h3>
    <canvas id="violationChart" height="120"></canvas>
</div>

<div class="card">
    <a href="{{ route('admin.reports.compliance.csv') }}">Download Compliance Summary (CSV)</a>
    <br>
    <a href="{{ route('admin.reports.distribution.csv') }}">Download Detailed Distribution Breakdown (CSV)</a>
    <br>
    <a href="{{ route('admin.reports.printable') }}" target="_blank">Open Printable Report (use browser Save as PDF)</a>
</div>

<script>
async function loadChartData() {
    const response = await fetch("{{ route('admin.reports.chart-data') }}");
    const data = await response.json();

    const lecturerCanvas = document.getElementById('lecturerChart');
    const lecturerCtx = lecturerCanvas.getContext('2d');
    lecturerCtx.clearRect(0, 0, lecturerCanvas.width, lecturerCanvas.height);
    lecturerCtx.fillText('Compliance by Lecturer', 10, 15);

    data.lecturer_labels.forEach((label, index) => {
        const value = data.lecturer_compliance_values[index] || 0;
        lecturerCtx.fillText(label + ': ' + value + '%', 10, 40 + (index * 20));
    });

    const violationCanvas = document.getElementById('violationChart');
    const violationCtx = violationCanvas.getContext('2d');
    violationCtx.clearRect(0, 0, violationCanvas.width, violationCanvas.height);
    violationCtx.fillText('Top Rule Violations', 10, 15);

    data.violation_labels.forEach((label, index) => {
        const value = data.violation_counts[index] || 0;
        violationCtx.fillText(label + ': ' + value, 10, 40 + (index * 20));
    });
}

loadChartData();
</script>
@endsection
