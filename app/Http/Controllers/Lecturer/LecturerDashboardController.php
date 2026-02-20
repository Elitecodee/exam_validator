<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LecturerDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $lecturerId = optional($request->user())->id;

        $total = Exam::query()->where('lecturer_id', $lecturerId)->count();
        $draft = Exam::query()->where('lecturer_id', $lecturerId)->where('status', 'draft')->count();
        $submitted = Exam::query()->where('lecturer_id', $lecturerId)->where('status', 'submitted')->count();
        $last = Exam::query()->where('lecturer_id', $lecturerId)->latest()->first();

        return view('lecturer.dashboard', [
            'stats' => [
                'total_exams' => $total,
                'draft_exams' => $draft,
                'submitted_exams' => $submitted,
                'last_status' => $last ? strtoupper($last->status) : 'No submissions yet',
            ],
        ]);
    }
}
