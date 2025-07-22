<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = [
        'daily_log_id', 'title', 'description', 'duration_minutes', 'intensity'
    ];

    public function dailyLog()
    {
        return $this->belongsTo(DailyLog::class);
    }
}
