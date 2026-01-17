<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnalysisRow extends Model
{
    use HasFactory;

    protected $fillable = [
        'analysis_id',
        'category',
        'actual_amount',
        'taps_percentage',
        'pf_amount',
        'bleed',
        'fix',
        'haps',
        'q1_caps',
        'q2_caps',
        'q3_caps',
        'q4_caps',
    ];

    public function analysis(): BelongsTo
    {
        return $this->belongsTo(Analysis::class);
    }
}
