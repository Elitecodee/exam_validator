@php
    $blueprint = $blueprint ?? null;
    $topicRules = $blueprint?->rules->where('rule_type', 'topic')->values();
    $difficultyRules = $blueprint?->rules->where('rule_type', 'difficulty')->values();
@endphp

<div class="row g-3">
    <div class="col-md-8">
        <label for="name" class="form-label">Blueprint Name</label>
        <input id="name" name="name" type="text" value="{{ old('name', $blueprint->name ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-4">
        <label for="course_id" class="form-label">Course ID</label>
        <input id="course_id" name="course_id" type="number" value="{{ old('course_id', $blueprint->course_id ?? '') }}" class="form-control">
    </div>

    <div class="col-md-4">
        <label for="total_marks" class="form-label">Total Marks</label>
        <input id="total_marks" name="total_marks" type="number" value="{{ old('total_marks', $blueprint->total_marks ?? 100) }}" class="form-control" required>
    </div>
    <div class="col-md-4">
        <label for="theory_percentage" class="form-label">Theory %</label>
        <input id="theory_percentage" name="theory_percentage" type="number" step="0.01" value="{{ old('theory_percentage', $blueprint->theory_percentage ?? 40) }}" class="form-control" required>
    </div>
    <div class="col-md-4">
        <label for="problem_solving_percentage" class="form-label">Problem Solving %</label>
        <input id="problem_solving_percentage" name="problem_solving_percentage" type="number" step="0.01" value="{{ old('problem_solving_percentage', $blueprint->problem_solving_percentage ?? 60) }}" class="form-control" required>
    </div>

    <div class="col-md-6">
        <label for="tolerance_percentage" class="form-label">Tolerance (±%)</label>
        <input id="tolerance_percentage" name="tolerance_percentage" type="number" step="0.01" value="{{ old('tolerance_percentage', $blueprint->tolerance_percentage ?? 5) }}" class="form-control" required>
    </div>
    <div class="col-md-6 d-flex align-items-end">
        <div class="form-check">
            <input id="is_active" name="is_active" type="checkbox" value="1" class="form-check-input" {{ old('is_active', ($blueprint->is_active ?? true)) ? 'checked' : '' }}>
            <label for="is_active" class="form-check-label">Active blueprint</label>
        </div>
    </div>
</div>

<hr class="my-4">
<h3 class="h5 text-primary">Topic Coverage Rules</h3>
<p class="text-secondary small">Expected totals must equal 100%.</p>

@for ($i = 0; $i < 3; $i++)
<div class="row g-2 mb-2">
    <div class="col-md-3"><input name="topic_names[]" type="text" class="form-control" value="{{ old('topic_names.' . $i, $topicRules[$i]->rule_key ?? ['Algebra', 'Calculus', 'Statistics'][$i]) }}" required></div>
    <div class="col-md-3"><input name="topic_expected[]" type="number" step="0.01" class="form-control" value="{{ old('topic_expected.' . $i, $topicRules[$i]->expected_percentage ?? [30,40,30][$i]) }}" required></div>
    <div class="col-md-3"><input name="topic_min[]" type="number" step="0.01" class="form-control" value="{{ old('topic_min.' . $i, $topicRules[$i]->min_percentage ?? [25,35,25][$i]) }}" required></div>
    <div class="col-md-3"><input name="topic_max[]" type="number" step="0.01" class="form-control" value="{{ old('topic_max.' . $i, $topicRules[$i]->max_percentage ?? [35,45,35][$i]) }}" required></div>
</div>
@endfor

<hr class="my-4">
<h3 class="h5 text-primary">Difficulty Rules</h3>
<p class="text-secondary small">Expected totals must equal 100%.</p>

@for ($i = 0; $i < 3; $i++)
<div class="row g-2 mb-2">
    <div class="col-md-3"><input name="difficulty_names[]" type="text" class="form-control" value="{{ old('difficulty_names.' . $i, $difficultyRules[$i]->rule_key ?? ['Easy', 'Medium', 'Hard'][$i]) }}" required></div>
    <div class="col-md-3"><input name="difficulty_expected[]" type="number" step="0.01" class="form-control" value="{{ old('difficulty_expected.' . $i, $difficultyRules[$i]->expected_percentage ?? [30,50,20][$i]) }}" required></div>
    <div class="col-md-3"><input name="difficulty_min[]" type="number" step="0.01" class="form-control" value="{{ old('difficulty_min.' . $i, $difficultyRules[$i]->min_percentage ?? [25,45,15][$i]) }}" required></div>
    <div class="col-md-3"><input name="difficulty_max[]" type="number" step="0.01" class="form-control" value="{{ old('difficulty_max.' . $i, $difficultyRules[$i]->max_percentage ?? [35,55,25][$i]) }}" required></div>
</div>
@endfor
