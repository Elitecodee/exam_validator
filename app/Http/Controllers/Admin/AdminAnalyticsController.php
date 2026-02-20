<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminAnalyticsService;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;

class AdminAnalyticsController extends Controller
{
    public function __construct(private readonly AdminAnalyticsService $analyticsService)
    {
    }

    public function index(): View
    {
        $analytics = $this->analyticsService->buildDashboardData();

        return view('admin.analytics.index', [
            'analytics' => $analytics,
        ]);
    }

    public function downloadComplianceCsv(): StreamedResponse
    {
        $rows = $this->analyticsService->buildComplianceRowsForExport();

        return response()->streamDownload(function () use ($rows): void {
            $handle = fopen('php://output', 'wb');

            fputcsv($handle, ['Validation ID', 'Exam ID', 'Lecturer ID', 'Result', 'Validated At']);
            foreach ($rows as $row) {
                fputcsv($handle, [
                    $row['validation_id'],
                    $row['exam_id'],
                    $row['lecturer_id'],
                    $row['result'],
                    $row['created_at'],
                ]);
            }

            fclose($handle);
        }, 'compliance-report.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }
}
