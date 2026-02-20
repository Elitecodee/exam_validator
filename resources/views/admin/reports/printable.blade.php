<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compliance Report</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 24px; color: #111827; }
        h1, h2 { margin-bottom: 8px; }
        .muted { color: #6b7280; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #d1d5db; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h1>Exam Validator Compliance Report</h1>
    <p class="muted">Generated at: {{ $generatedAt }}</p>

    <h2>Summary</h2>
    <table>
        <tr><th>Total Blueprints</th><td>{{ $analytics['kpis']['total_blueprints'] }}</td></tr>
        <tr><th>Total Exams</th><td>{{ $analytics['kpis']['total_exams'] }}</td></tr>
        <tr><th>Total Validations</th><td>{{ $analytics['kpis']['total_validations'] }}</td></tr>
        <tr><th>Overall Compliance Rate</th><td>{{ $analytics['kpis']['overall_compliance_rate'] }}%</td></tr>
    </table>

    <h2>Compliance by Lecturer</h2>
    <table>
        <thead>
            <tr>
                <th>Lecturer ID</th>
                <th>Attempts</th>
                <th>Passes</th>
                <th>Fails</th>
                <th>Compliance Rate</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($analytics['lecturer_compliance'] as $row)
                <tr>
                    <td>{{ $row['lecturer_id'] ?? 'N/A' }}</td>
                    <td>{{ $row['attempts'] }}</td>
                    <td>{{ $row['passes'] }}</td>
                    <td>{{ $row['fails'] }}</td>
                    <td>{{ $row['compliance_rate'] }}%</td>
                </tr>
            @empty
                <tr><td colspan="5">No data</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Common Violations</h2>
    <table>
        <thead>
            <tr>
                <th>Rule</th>
                <th>Count</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($analytics['common_violations'] as $row)
                <tr>
                    <td>{{ $row['rule'] }}</td>
                    <td>{{ $row['count'] }}</td>
                </tr>
            @empty
                <tr><td colspan="2">No data</td></tr>
            @endforelse
        </tbody>
    </table>

    <script>
        window.onload = function () { window.print(); };
    </script>
</body>
</html>
