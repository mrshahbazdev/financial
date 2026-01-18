<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Analysis extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'real_revenue',
        'client_name',
        'q1_revenue_data',
        'q2_revenue_data',
        'q3_revenue_data',
        'q4_revenue_data',
    ];

    protected $casts = [
        'q1_revenue_data' => 'array',
        'q2_revenue_data' => 'array',
        'q3_revenue_data' => 'array',
        'q4_revenue_data' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rows(): HasMany
    {
        return $this->hasMany(AnalysisRow::class);
    }
}
