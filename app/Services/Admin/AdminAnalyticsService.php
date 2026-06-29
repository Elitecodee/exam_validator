<?php

namespace App\Services\Admin;

use App\Models\Exam;
use App\Models\ValidationHistory;

class AdminAnalyticsService
{
    public function buildDashboardData(): array
    {
        $histories = ValidationHistory::query()->with('exam')->get();

        $totalValidations = $histories->count();
        $passCount = $histories->where('result', 'pass')->count();
        $complianceRate = $totalValidations > 0
            ? round(($passCount / $totalValidations) * 100, 2)
            : 0.0;

        $byLecturer = [];
        $violationCounts = [];

        foreach ($histories as $history) {
            $exam = $history->exam;
            if (!$exam) {
                continue;
            }

            $lecturerId = (string) ($exam->lecturer_id ?? 'unknown');
            if (!isset($byLecturer[$lecturerId])) {
                $byLecturer[$lecturerId] = [
                    'lecturer_id' => $exam->lecturer_id,
                    'attempts' => 0,
                    'passes' => 0,
                    'fails' => 0,
                ];
            }

            $byLecturer[$lecturerId]['attempts']++;
            if ($history->result === 'pass') {
                $byLecturer[$lecturerId]['passes']++;
            } else {
                $byLecturer[$lecturerId]['fails']++;
            }

            $summary = is_array($history->summary) ? $history->summary : [];
            $violations = $summary['violations'] ?? [];
            foreach ($violations as $violation) {
                $rule = (string) ($violation['rule'] ?? 'Unknown');
                $violationCounts[$rule] = ($violationCounts[$rule] ?? 0) + 1;
            }
        }

        $lecturerRows = array_values(array_map(function (array $row): array {
            $row['compliance_rate'] = $row['attempts'] > 0
                ? round(($row['passes'] / $row['attempts']) * 100, 2)
                : 0.0;

            return $row;
        }, $byLecturer));

        usort($lecturerRows, fn (array $a, array $b): int => $b['compliance_rate'] <=> $a['compliance_rate']);

        arsort($violationCounts);
        $commonViolations = [];
        foreach ($violationCounts as $rule => $count) {
            $commonViolations[] = ['rule' => $rule, 'count' => $count];
        }

        return [
            'kpis' => [
                'total_blueprints' => \App\Models\Blueprint::query()->count(),
                'total_exams' => Exam::query()->count(),
                'total_validations' => $totalValidations,
                'overall_compliance_rate' => $complianceRate,
            ],
            'lecturer_compliance' => $lecturerRows,
            'common_violations' => array_slice($commonViolations, 0, 10),
        ];
    }

    public function buildComplianceRowsForExport(): array
    {
        $histories = ValidationHistory::query()->with('exam')->latest('created_at')->get();
        $rows = [];

        foreach ($histories as $history) {
            $exam = $history->exam;
            if (!$exam) {
                continue;
            }

            $rows[] = [
                'validation_id' => $history->id,
                'exam_id' => $exam->id,
                'lecturer_id' => $exam->lecturer_id,
                'result' => strtoupper($history->result),
                'created_at' => (string) $history->created_at,
            ];
        }

        return $rows;
    }
}
