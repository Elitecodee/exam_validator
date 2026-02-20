<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ValidationHistory;
use App\Services\Admin\AdminAnalyticsService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;

class AdminReportingController extends Controller
{
    public function __construct(private readonly AdminAnalyticsService $analyticsService)
    {
    }

    public function index(): View
    {
        $analytics = $this->analyticsService->buildDashboardData();

        return view('admin.reports.index', [
            'analytics' => $analytics,
        ]);
    }

    public function chartData(): JsonResponse
    {
        $analytics = $this->analyticsService->buildDashboardData();

        return response()->json([
            'overall_compliance_rate' => $analytics['kpis']['overall_compliance_rate'],
            'lecturer_labels' => array_map(
                fn (array $row): string => 'Lecturer ' . ($row['lecturer_id'] ?? 'N/A'),
                $analytics['lecturer_compliance']
            ),
            'lecturer_compliance_values' => array_map(
                fn (array $row): float => (float) $row['compliance_rate'],
                $analytics['lecturer_compliance']
            ),
            'violation_labels' => array_map(
                fn (array $row): string => (string) $row['rule'],
                $analytics['common_violations']
            ),
            'violation_counts' => array_map(
                fn (array $row): int => (int) $row['count'],
                $analytics['common_violations']
            ),
        ]);
    }

    public function exportTopicBreakdownCsv(): StreamedResponse
    {
        $histories = ValidationHistory::query()->latest('created_at')->get();

        return response()->streamDownload(function () use ($histories): void {
            $handle = fopen('php://output', 'wb');
            fputcsv($handle, ['Validation ID', 'Rule Type', 'Rule Key', 'Expected %', 'Current %', 'Deviation %', 'Status']);

            foreach ($histories as $history) {
                $summary = is_array($history->summary) ? $history->summary : [];
                $sections = $summary['sections'] ?? [];

                foreach (['topic', 'difficulty', 'type'] as $section) {
                    $rows = $sections[$section] ?? [];
                    foreach ($rows as $row) {
                        fputcsv($handle, [
                            $history->id,
                            $section,
                            $row['rule_key'] ?? '',
                            $row['expected_percentage'] ?? '',
                            $row['current_percentage'] ?? '',
                            $row['deviation_percentage'] ?? '',
                            $row['status'] ?? '',
                        ]);
                    }
                }
            }

            fclose($handle);
        }, 'distribution-breakdown-report.csv', ['Content-Type' => 'text/csv']);
    }

    public function printable(): View
    {
        $analytics = $this->analyticsService->buildDashboardData();

        return view('admin.reports.printable', [
            'analytics' => $analytics,
            'generatedAt' => now()->toDateTimeString(),
        ]);
    }
}
