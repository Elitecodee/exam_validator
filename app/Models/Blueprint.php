<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Blueprint extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'name',
        'total_marks',
        'theory_percentage',
        'problem_solving_percentage',
        'tolerance_percentage',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function rules(): HasMany
    {
        return $this->hasMany(BlueprintRule::class);
    }

    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }
}
