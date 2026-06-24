<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Services\ExamValidationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminExamReviewController extends Controller
{
    public function __construct(private readonly ExamValidationService $validationService)
    {
    }

    public function index(): View
    {
        $submittedExams = Exam::query()
            ->where('status', 'submitted')
            ->withCount('questions')
            ->latest('submitted_at')
            ->get();

        $reviewedExams = Exam::query()
            ->whereIn('status', ['approved', 'rejected'])
            ->withCount('questions')
            ->latest('reviewed_at')
            ->limit(25)
            ->get();

        return view('admin.exams.index', [
            'submittedExams' => $submittedExams,
            'reviewedExams' => $reviewedExams,
        ]);
    }

    public function show(Exam $exam): View
    {
        $exam->load(['questions', 'blueprint.rules', 'validationHistories']);
        $report = $this->validationService->buildReport($exam);

        return view('admin.exams.show', [
            'exam' => $exam,
            'report' => $report,
        ]);
    }

    public function approve(Request $request, Exam $exam): RedirectResponse
    {
        if ($exam->status !== 'submitted') {
            return back()->withErrors(['review' => 'Only submitted exams can be approved.']);
        }

        $exam->update([
            'status' => 'approved',
            'reviewed_by' => optional($request->user())->id,
            'reviewed_at' => now(),
            'review_note' => $request->input('review_note'),
        ]);

        return redirect()->route('admin.exams.index')
            ->with('status', 'Exam approved successfully.');
    }

    public function reject(Request $request, Exam $exam): RedirectResponse
    {
        if ($exam->status !== 'submitted') {
            return back()->withErrors(['review' => 'Only submitted exams can be rejected.']);
        }

        $validated = $request->validate([
            'review_note' => ['required', 'string', 'min:5'],
        ]);

        $exam->update([
            'status' => 'rejected',
            'reviewed_by' => optional($request->user())->id,
            'reviewed_at' => now(),
            'review_note' => $validated['review_note'],
        ]);

        return redirect()->route('admin.exams.index')
            ->with('status', 'Exam rejected with feedback.');
    }
}
