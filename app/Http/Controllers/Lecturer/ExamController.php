<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExamController extends Controller
{
    public function index(): View
    {
        return view('lecturer.exams-index', [
            'exams' => [],
        ]);
    }

    public function create(): View
    {
        return view('lecturer.exams-create', [
            'courses' => [],
            'blueprints' => [],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'course_id' => ['required', 'integer'],
            'blueprint_id' => ['required', 'integer'],
        ]);

        // Persist exam in next implementation step.

        return redirect()->route('lecturer.exams.index')
            ->with('status', 'Exam draft created successfully.');
    }

    public function show(string $exam): View
    {
        return view('lecturer.exams-show', [
            'examId' => $exam,
            'questions' => [],
        ]);
    }
}
