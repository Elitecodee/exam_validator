<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class LecturerDashboardController extends Controller
{
    public function index(): View
    {
        return view('lecturer.dashboard', [
            'stats' => [
                'total_exams' => 0,
                'draft_exams' => 0,
                'submitted_exams' => 0,
                'last_status' => 'No submissions yet',
            ],
        ]);
    }
}
