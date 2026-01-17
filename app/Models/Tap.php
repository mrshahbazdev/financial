<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tap extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'label',
        'industry',
        'min_revenue',
        'max_revenue',
        'profit',
        'owner_pay',
        'tax',
        'opex',
    ];
}
