<?php

namespace App\Http\Controllers\Lecturer;

use App\Http\Controllers\Controller;
use App\Models\Blueprint;
use App\Models\Exam;
use App\Services\ExamValidationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExamController extends Controller
{
    public function __construct(private readonly ExamValidationService $validationService)
    {
    }

    public function index(Request $request): View
    {
        $exams = Exam::query()
            ->where('lecturer_id', optional($request->user())->id)
            ->withCount('questions')
            ->latest()
            ->get();

        return view('lecturer.exams.index', [
            'exams' => $exams,
        ]);
    }

    public function create(): View
    {
        $blueprints = Blueprint::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('lecturer.exams.create', [
            'blueprints' => $blueprints,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'course_id' => ['nullable', 'integer'],
            'blueprint_id' => ['required', 'integer', 'exists:blueprints,id'],
        ]);

        $exam = Exam::create([
            'title' => $validated['title'],
            'course_id' => $validated['course_id'] ?? null,
            'blueprint_id' => $validated['blueprint_id'],
            'lecturer_id' => optional($request->user())->id,
            'status' => 'draft',
        ]);

        return redirect()->route('lecturer.exams.show', $exam)
            ->with('status', 'Exam draft created successfully. You can now add questions.');
    }

    public function show(Request $request, Exam $exam): View
    {
        $this->authorizeExam($request, $exam);

        $exam->load(['questions', 'blueprint.rules']);
        $report = $this->validationService->buildReport($exam);

        return view('lecturer.exams.show', [
            'exam' => $exam,
            'report' => $report,
        ]);
    }

    public function addQuestion(Request $request, Exam $exam): RedirectResponse
    {
        $this->authorizeExam($request, $exam);

        $validated = $request->validate([
            'question_text' => ['required', 'string'],
            'question_type' => ['required', 'in:theory,problem_solving'],
            'topic' => ['required', 'string', 'max:100'],
            'difficulty' => ['required', 'in:easy,medium,hard'],
            'marks' => ['required', 'numeric', 'min:0.5'],
        ]);

        $exam->questions()->create($validated);

        return redirect()->route('lecturer.exams.show', $exam)
            ->with('status', 'Question added. Validation summary refreshed.');
    }

    public function submit(Request $request, Exam $exam): RedirectResponse
    {
        $this->authorizeExam($request, $exam);

        $report = $this->validationService->buildReport($exam);

        if (!$report['passed']) {
            return redirect()->route('lecturer.exams.show', $exam)
                ->withErrors(['submit' => 'Exam submission failed compliance checks.'])
                ->with('status', 'Please fix violations before submitting.');
        }

        $exam->update([
            'status' => 'submitted',
            'submitted_at' => now(),
            'validation_score' => 100,
        ]);

        return redirect()->route('lecturer.exams.show', $exam)
            ->with('status', 'Exam submitted successfully. Final compliance: PASS.');
    }

    private function authorizeExam(Request $request, Exam $exam): void
    {
        if ($exam->lecturer_id !== optional($request->user())->id) {
            abort(403, 'You are not authorized to access this exam.');
        }
    }
}
