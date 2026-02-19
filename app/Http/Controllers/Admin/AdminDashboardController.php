<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'total_blueprints' => 0,
                'exam_submissions' => 0,
                'compliance_rate' => '0%',
                'common_violation' => 'N/A',
            ],
        ]);
    }
}
