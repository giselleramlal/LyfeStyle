<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'daily_log_id', 'meal_type', 'description', 'calories', 'protein', 'carbs', 'fat'
    ];

    public function dailyLog()
    {
        return $this->belongsTo(DailyLog::class);
    }
}
