<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ValidationHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'validated_by',
        'result',
        'summary',
    ];

    protected $casts = [
        'summary' => 'array',
    ];

    public $timestamps = false;

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }
}
