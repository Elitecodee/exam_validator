<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'blueprint_id',
        'lecturer_id',
        'title',
        'status',
        'validation_score',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function blueprint(): BelongsTo
    {
        return $this->belongsTo(Blueprint::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function validationHistories(): HasMany
    {
        return $this->hasMany(ValidationHistory::class);
    }
}
