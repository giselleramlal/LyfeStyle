<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SleepLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'daily_log_id', 'sleep_time', 'wake_time', 'duration_hours', 'quality'
    ];

    public function dailyLog()
    {
        return $this->belongsTo(DailyLog::class);
    }
}
