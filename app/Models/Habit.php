<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Habit extends Model
{
    use HasFactory;

    protected $fillable = [
        'daily_log_id', 'description', 'is_completed'
    ];

    protected $casts = [
        'is_completed' => 'boolean',
    ];

    public function dailyLog()
    {
        return $this->belongsTo(DailyLog::class);
    }
}
