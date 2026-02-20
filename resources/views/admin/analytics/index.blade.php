@extends('layouts.app', ['title' => 'Admin Analytics'])

@section('content')
<h1>Admin Analytics</h1>
<p class="muted">Compliance rate by lecturer, common violations, and export tools.</p>

<div class="grid">
    <div class="card"><strong>Total Blueprints</strong><br>{{ $analytics['kpis']['total_blueprints'] }}</div>
    <div class="card"><strong>Total Exams</strong><br>{{ $analytics['kpis']['total_exams'] }}</div>
    <div class="card"><strong>Total Validations</strong><br>{{ $analytics['kpis']['total_validations'] }}</div>
    <div class="card"><strong>Overall Compliance</strong><br>{{ $analytics['kpis']['overall_compliance_rate'] }}%</div>
</div>

<div class="card">
    <h3>Compliance Rate by Lecturer</h3>
    <table style="width:100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="text-align:left; padding:6px;">Lecturer ID</th>
                <th style="text-align:left; padding:6px;">Attempts</th>
                <th style="text-align:left; padding:6px;">Passes</th>
                <th style="text-align:left; padding:6px;">Fails</th>
                <th style="text-align:left; padding:6px;">Compliance Rate</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($analytics['lecturer_compliance'] as $row)
                <tr>
                    <td style="padding:6px;">{{ $row['lecturer_id'] ?? 'N/A' }}</td>
                    <td style="padding:6px;">{{ $row['attempts'] }}</td>
                    <td style="padding:6px;">{{ $row['passes'] }}</td>
                    <td style="padding:6px;">{{ $row['fails'] }}</td>
                    <td style="padding:6px;">{{ $row['compliance_rate'] }}%</td>
                </tr>
            @empty
                <tr><td colspan="5" class="muted" style="padding:6px;">No lecturer validation data yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="card">
    <h3>Most Common Rule Violations</h3>
    <table style="width:100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="text-align:left; padding:6px;">Rule</th>
                <th style="text-align:left; padding:6px;">Count</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($analytics['common_violations'] as $row)
                <tr>
                    <td style="padding:6px;">{{ $row['rule'] }}</td>
                    <td style="padding:6px;">{{ $row['count'] }}</td>
                </tr>
            @empty
                <tr><td colspan="2" class="muted" style="padding:6px;">No violations recorded.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="card">
    <a href="{{ route('admin.reports.compliance.csv') }}">Download Compliance Report (CSV)</a>
</div>
@endsection
