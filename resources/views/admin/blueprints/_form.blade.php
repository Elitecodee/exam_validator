@php
    $blueprint = $blueprint ?? null;
    $topicRules = $blueprint?->rules->where('rule_type', 'topic')->values();
    $difficultyRules = $blueprint?->rules->where('rule_type', 'difficulty')->values();
@endphp

<label for="name">Blueprint Name</label>
<input id="name" name="name" type="text" value="{{ old('name', $blueprint->name ?? '') }}" required>

<label for="course_id">Course ID (optional placeholder)</label>
<input id="course_id" name="course_id" type="number" value="{{ old('course_id', $blueprint->course_id ?? '') }}">

<label for="total_marks">Total Marks</label>
<input id="total_marks" name="total_marks" type="number" value="{{ old('total_marks', $blueprint->total_marks ?? 100) }}" required>

<div class="grid">
    <div>
        <label for="theory_percentage">Theory Percentage</label>
        <input id="theory_percentage" name="theory_percentage" type="number" step="0.01" value="{{ old('theory_percentage', $blueprint->theory_percentage ?? 40) }}" required>
    </div>
    <div>
        <label for="problem_solving_percentage">Problem Solving Percentage</label>
        <input id="problem_solving_percentage" name="problem_solving_percentage" type="number" step="0.01" value="{{ old('problem_solving_percentage', $blueprint->problem_solving_percentage ?? 60) }}" required>
    </div>
</div>

<label for="tolerance_percentage">Tolerance (±%)</label>
<input id="tolerance_percentage" name="tolerance_percentage" type="number" step="0.01" value="{{ old('tolerance_percentage', $blueprint->tolerance_percentage ?? 5) }}" required>

<label>
    <input name="is_active" type="checkbox" value="1" style="width:auto;"
        {{ old('is_active', ($blueprint->is_active ?? true)) ? 'checked' : '' }}>
    Active blueprint
</label>

<hr>
<h3>Topic Coverage Rules</h3>
<p class="muted">Expected topic totals must equal 100%.</p>

@for ($i = 0; $i < 3; $i++)
    <div class="grid">
        <div>
            <label>Topic {{ $i + 1 }} Name</label>
            <input name="topic_names[]" type="text" value="{{ old('topic_names.' . $i, $topicRules[$i]->rule_key ?? ['Algebra', 'Calculus', 'Statistics'][$i]) }}" required>
        </div>
        <div>
            <label>Expected %</label>
            <input name="topic_expected[]" type="number" step="0.01" value="{{ old('topic_expected.' . $i, $topicRules[$i]->expected_percentage ?? [30,40,30][$i]) }}" required>
        </div>
        <div>
            <label>Min %</label>
            <input name="topic_min[]" type="number" step="0.01" value="{{ old('topic_min.' . $i, $topicRules[$i]->min_percentage ?? [25,35,25][$i]) }}" required>
        </div>
        <div>
            <label>Max %</label>
            <input name="topic_max[]" type="number" step="0.01" value="{{ old('topic_max.' . $i, $topicRules[$i]->max_percentage ?? [35,45,35][$i]) }}" required>
        </div>
    </div>
@endfor

<hr>
<h3>Difficulty Rules</h3>
<p class="muted">Expected difficulty totals must equal 100%.</p>

@for ($i = 0; $i < 3; $i++)
    <div class="grid">
        <div>
            <label>Difficulty {{ $i + 1 }} Name</label>
            <input name="difficulty_names[]" type="text" value="{{ old('difficulty_names.' . $i, $difficultyRules[$i]->rule_key ?? ['Easy', 'Medium', 'Hard'][$i]) }}" required>
        </div>
        <div>
            <label>Expected %</label>
            <input name="difficulty_expected[]" type="number" step="0.01" value="{{ old('difficulty_expected.' . $i, $difficultyRules[$i]->expected_percentage ?? [30,50,20][$i]) }}" required>
        </div>
        <div>
            <label>Min %</label>
            <input name="difficulty_min[]" type="number" step="0.01" value="{{ old('difficulty_min.' . $i, $difficultyRules[$i]->min_percentage ?? [25,45,15][$i]) }}" required>
        </div>
        <div>
            <label>Max %</label>
            <input name="difficulty_max[]" type="number" step="0.01" value="{{ old('difficulty_max.' . $i, $difficultyRules[$i]->max_percentage ?? [35,55,25][$i]) }}" required>
        </div>
    </div>
@endfor
