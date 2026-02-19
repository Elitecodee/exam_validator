<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blueprint;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'total_blueprints' => Blueprint::query()->count(),
                'exam_submissions' => 0,
                'compliance_rate' => '0%',
                'common_violation' => 'N/A',
            ],
        ]);
    }
}
