<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminAnalyticsService;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __construct(private readonly AdminAnalyticsService $analyticsService)
    {
    }

    public function index(): View
    {
        $analytics = $this->analyticsService->buildDashboardData();

        return view('admin.dashboard', [
            'kpis' => $analytics['kpis'],
            'top_lecturers' => array_slice($analytics['lecturer_compliance'], 0, 5),
            'common_violations' => array_slice($analytics['common_violations'], 0, 5),
        ]);
    }
}
