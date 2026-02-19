<?php

namespace App\Services;

use App\Models\Blueprint;
use App\Models\Exam;

class ExamValidationService
{
    public function buildReport(Exam $exam): array
    {
        $exam->loadMissing(['questions', 'blueprint.rules']);

        $totalMarks = (float) $exam->questions->sum('marks');
        $blueprint = $exam->blueprint;

        $actualByType = $this->aggregateBy($exam, 'question_type');
        $actualByTopic = $this->aggregateBy($exam, 'topic');
        $actualByDifficulty = $this->aggregateBy($exam, 'difficulty');

        $sections = [
            'type' => $this->buildSection($blueprint, 'type', $actualByType, $totalMarks),
            'topic' => $this->buildSection($blueprint, 'topic', $actualByTopic, $totalMarks),
            'difficulty' => $this->buildSection($blueprint, 'difficulty', $actualByDifficulty, $totalMarks),
        ];

        $violations = [];
        foreach ($sections as $sectionItems) {
            foreach ($sectionItems as $item) {
                if (!$item['within_range']) {
                    $violations[] = [
                        'rule' => strtoupper($item['rule_type']) . ' - ' . $item['rule_key'],
                        'message' => $item['status'],
                        'suggestion' => $item['suggestion'],
                    ];
                }
            }
        }

        if ($blueprint && round($totalMarks, 2) !== round((float) $blueprint->total_marks, 2)) {
            $diff = round($totalMarks - (float) $blueprint->total_marks, 2);
            $violations[] = [
                'rule' => 'TOTAL_MARKS',
                'message' => $diff > 0
                    ? 'Total marks exceed blueprint by ' . $diff
                    : 'Total marks are short by ' . abs($diff),
                'suggestion' => 'Adjust question marks so total equals ' . $blueprint->total_marks . '.',
            ];
        }

        $passed = count($violations) === 0;

        return [
            'passed' => $passed,
            'summary' => $passed ? 'Pass' : 'Fail',
            'total_marks_expected' => (float) ($blueprint->total_marks ?? 0),
            'total_marks_current' => $totalMarks,
            'sections' => $sections,
            'violations' => $violations,
        ];
    }

    private function aggregateBy(Exam $exam, string $column): array
    {
        $grouped = [];

        foreach ($exam->questions as $question) {
            $key = (string) $question->{$column};
            $grouped[$key] = ($grouped[$key] ?? 0) + (float) $question->marks;
        }

        return $grouped;
    }

    private function buildSection(?Blueprint $blueprint, string $ruleType, array $actualMarksByKey, float $totalMarks): array
    {
        if (!$blueprint) {
            return [];
        }

        $rows = [];
        $rules = $blueprint->rules->where('rule_type', $ruleType)->values();

        foreach ($rules as $rule) {
            $actualMarks = (float) ($actualMarksByKey[$rule->rule_key] ?? 0);
            $actualPercentage = $totalMarks > 0 ? round(($actualMarks / $totalMarks) * 100, 2) : 0.0;
            $expected = (float) $rule->expected_percentage;
            $deviation = round($actualPercentage - $expected, 2);
            $withinRange = $actualPercentage >= (float) $rule->min_percentage && $actualPercentage <= (float) $rule->max_percentage;

            $status = $withinRange
                ? 'Within allowed range'
                : ($deviation > 0
                    ? 'Exceeded by ' . abs($deviation) . '%'
                    : 'Below by ' . abs($deviation) . '%');

            $rows[] = [
                'rule_type' => $ruleType,
                'rule_key' => $rule->rule_key,
                'expected_percentage' => $expected,
                'current_percentage' => $actualPercentage,
                'deviation_percentage' => $deviation,
                'min_allowed' => (float) $rule->min_percentage,
                'max_allowed' => (float) $rule->max_percentage,
                'status' => $status,
                'within_range' => $withinRange,
                'suggestion' => $this->suggestion($rule->rule_key, $deviation),
            ];
        }

        return $rows;
    }

    private function suggestion(string $ruleKey, float $deviation): string
    {
        if ($deviation > 0) {
            return 'Reduce marks/questions for ' . $ruleKey . ' or increase other categories.';
        }

        if ($deviation < 0) {
            return 'Add more marks/questions for ' . $ruleKey . ' to meet the target range.';
        }

        return 'No change needed.';
    }
}
