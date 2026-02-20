<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlueprintRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'blueprint_id',
        'rule_type',
        'rule_key',
        'expected_percentage',
        'min_percentage',
        'max_percentage',
    ];

    public function blueprint(): BelongsTo
    {
        return $this->belongsTo(Blueprint::class);
    }
}
