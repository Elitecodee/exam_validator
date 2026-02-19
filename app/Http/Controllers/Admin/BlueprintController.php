<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blueprint;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BlueprintController extends Controller
{
    public function index(): View
    {
        $blueprints = Blueprint::query()->latest()->get();

        return view('admin.blueprints.index', compact('blueprints'));
    }

    public function create(): View
    {
        return view('admin.blueprints.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateBlueprint($request);

        DB::transaction(function () use ($request, $validated): void {
            $blueprint = Blueprint::create([
                'name' => $validated['name'],
                'course_id' => $validated['course_id'] ?? null,
                'total_marks' => $validated['total_marks'],
                'theory_percentage' => $validated['theory_percentage'],
                'problem_solving_percentage' => $validated['problem_solving_percentage'],
                'tolerance_percentage' => $validated['tolerance_percentage'],
                'is_active' => $request->boolean('is_active', true),
                'created_by' => optional($request->user())->id,
            ]);

            $this->syncRules($blueprint, $validated);
        });

        return redirect()->route('admin.blueprints.index')->with('status', 'Blueprint created successfully.');
    }

    public function edit(Blueprint $blueprint): View
    {
        $blueprint->load('rules');

        return view('admin.blueprints.edit', compact('blueprint'));
    }

    public function update(Request $request, Blueprint $blueprint): RedirectResponse
    {
        $validated = $this->validateBlueprint($request);

        DB::transaction(function () use ($request, $validated, $blueprint): void {
            $blueprint->update([
                'name' => $validated['name'],
                'course_id' => $validated['course_id'] ?? null,
                'total_marks' => $validated['total_marks'],
                'theory_percentage' => $validated['theory_percentage'],
                'problem_solving_percentage' => $validated['problem_solving_percentage'],
                'tolerance_percentage' => $validated['tolerance_percentage'],
                'is_active' => $request->boolean('is_active', true),
            ]);

            $blueprint->rules()->delete();
            $this->syncRules($blueprint, $validated);
        });

        return redirect()->route('admin.blueprints.index')->with('status', 'Blueprint updated successfully.');
    }

    public function destroy(Blueprint $blueprint): RedirectResponse
    {
        $blueprint->delete();

        return redirect()->route('admin.blueprints.index')->with('status', 'Blueprint deleted successfully.');
    }

    public function toggle(Blueprint $blueprint): RedirectResponse
    {
        $blueprint->update(['is_active' => !$blueprint->is_active]);

        return redirect()->route('admin.blueprints.index')
            ->with('status', 'Blueprint status updated.');
    }

    private function validateBlueprint(Request $request): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'course_id' => ['nullable', 'integer'],
            'total_marks' => ['required', 'integer', 'min:1'],
            'theory_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'problem_solving_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'tolerance_percentage' => ['required', 'numeric', 'min:0', 'max:100'],

            'topic_names' => ['required', 'array', 'min:1'],
            'topic_names.*' => ['required', 'string', 'max:100'],
            'topic_expected' => ['required', 'array', 'min:1'],
            'topic_expected.*' => ['required', 'numeric', 'min:0', 'max:100'],
            'topic_min' => ['required', 'array', 'min:1'],
            'topic_min.*' => ['required', 'numeric', 'min:0', 'max:100'],
            'topic_max' => ['required', 'array', 'min:1'],
            'topic_max.*' => ['required', 'numeric', 'min:0', 'max:100'],

            'difficulty_names' => ['required', 'array', 'min:1'],
            'difficulty_names.*' => ['required', 'string', 'max:100'],
            'difficulty_expected' => ['required', 'array', 'min:1'],
            'difficulty_expected.*' => ['required', 'numeric', 'min:0', 'max:100'],
            'difficulty_min' => ['required', 'array', 'min:1'],
            'difficulty_min.*' => ['required', 'numeric', 'min:0', 'max:100'],
            'difficulty_max' => ['required', 'array', 'min:1'],
            'difficulty_max.*' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        $this->assertSumsAndRanges($validated);

        return $validated;
    }

    private function assertSumsAndRanges(array $validated): void
    {
        $typeTotal = (float) $validated['theory_percentage'] + (float) $validated['problem_solving_percentage'];
        $topicTotal = array_sum(array_map('floatval', $validated['topic_expected']));
        $difficultyTotal = array_sum(array_map('floatval', $validated['difficulty_expected']));

        if (round($typeTotal, 2) !== 100.00) {
            throw ValidationException::withMessages([
                'theory_percentage' => 'Theory + Problem Solving percentages must equal 100%.',
            ]);
        }

        if (round($topicTotal, 2) !== 100.00) {
            throw ValidationException::withMessages([
                'topic_expected' => 'Total topic expected percentages must equal 100%.',
            ]);
        }

        if (round($difficultyTotal, 2) !== 100.00) {
            throw ValidationException::withMessages([
                'difficulty_expected' => 'Total difficulty expected percentages must equal 100%.',
            ]);
        }

        foreach (['topic', 'difficulty'] as $group) {
            $expectedValues = $validated["{$group}_expected"];
            $minValues = $validated["{$group}_min"];
            $maxValues = $validated["{$group}_max"];

            foreach ($expectedValues as $index => $expected) {
                $min = (float) $minValues[$index];
                $max = (float) $maxValues[$index];
                $currentExpected = (float) $expected;

                if ($min > $max || $currentExpected < $min || $currentExpected > $max) {
                    throw ValidationException::withMessages([
                        "{$group}_expected" => ucfirst($group) . ' expected value must stay within min and max limits.',
                    ]);
                }
            }
        }
    }

    private function syncRules(Blueprint $blueprint, array $validated): void
    {
        $typeRules = [
            [
                'rule_type' => 'type',
                'rule_key' => 'theory',
                'expected_percentage' => $validated['theory_percentage'],
                'min_percentage' => max(0, $validated['theory_percentage'] - $validated['tolerance_percentage']),
                'max_percentage' => min(100, $validated['theory_percentage'] + $validated['tolerance_percentage']),
            ],
            [
                'rule_type' => 'type',
                'rule_key' => 'problem_solving',
                'expected_percentage' => $validated['problem_solving_percentage'],
                'min_percentage' => max(0, $validated['problem_solving_percentage'] - $validated['tolerance_percentage']),
                'max_percentage' => min(100, $validated['problem_solving_percentage'] + $validated['tolerance_percentage']),
            ],
        ];

        $topicRules = [];
        foreach ($validated['topic_names'] as $index => $name) {
            $topicRules[] = [
                'rule_type' => 'topic',
                'rule_key' => $name,
                'expected_percentage' => $validated['topic_expected'][$index],
                'min_percentage' => $validated['topic_min'][$index],
                'max_percentage' => $validated['topic_max'][$index],
            ];
        }

        $difficultyRules = [];
        foreach ($validated['difficulty_names'] as $index => $name) {
            $difficultyRules[] = [
                'rule_type' => 'difficulty',
                'rule_key' => $name,
                'expected_percentage' => $validated['difficulty_expected'][$index],
                'min_percentage' => $validated['difficulty_min'][$index],
                'max_percentage' => $validated['difficulty_max'][$index],
            ];
        }

        $blueprint->rules()->createMany(array_merge($typeRules, $topicRules, $difficultyRules));
    }
}
