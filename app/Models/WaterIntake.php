<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WaterIntake extends Model
{
    use HasFactory;

    protected $fillable = [
        'daily_log_id', 'glasses'
    ];

    public function dailyLog()
    {
        return $this->belongsTo(DailyLog::class);
    }
}
