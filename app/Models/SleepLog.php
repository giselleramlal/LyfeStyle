<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class SleepLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'daily_log_id', 
        'date',
        'sleep_time', 
        'wake_time', 
        'duration_hours', 
        'quality',
        'notes'
    ];

    protected $casts = [
        'date' => 'date',
        'quality' => 'integer',
        'duration_hours' => 'decimal:2'
    ];

    protected $appends = ['formatted_duration'];

    public function dailyLog()
    {
        return $this->belongsTo(DailyLog::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Calculate duration automatically when sleep_time and wake_time are set
    public function calculateDuration()
    {
        if (!$this->sleep_time || !$this->wake_time || !$this->date) {
            return 0;
        }

        // Convert date to Carbon instance if it's not already
        $date = $this->date instanceof Carbon ? $this->date : Carbon::parse($this->date);
        
        // Create datetime objects using createFromFormat to avoid parsing issues
        $sleepDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $date->format('Y-m-d') . ' ' . $this->sleep_time . ':00');
        $wakeDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $date->format('Y-m-d') . ' ' . $this->wake_time . ':00');
        
        // If wake time is earlier than sleep time, assume it's the next day
        if ($wakeDateTime->lte($sleepDateTime)) {
            $wakeDateTime->addDay();
        }
        
        return round($wakeDateTime->diffInMinutes($sleepDateTime) / 60, 2);
    }

    // Accessor for formatted duration display
    public function getFormattedDurationAttribute()
    {
        if (!$this->duration_hours) {
            return '0h 0m';
        }
        
        $hours = floor($this->duration_hours);
        $minutes = round(($this->duration_hours - $hours) * 60);
        
        return "{$hours}h {$minutes}m";
    }

    // Boot method to auto-calculate duration
    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($sleepLog) {
            $sleepLog->duration_hours = $sleepLog->calculateDuration();
        });
    }

    // Scope for current user
    public function scopeForUser($query, $userId = null)
    {
        $userId = $userId ?: auth()->id();
        return $query->where('user_id', $userId);
    }

    // Scope for date range
    public function scopeDateRange($query, $startDate, $endDate = null)
    {
        $endDate = $endDate ?: $startDate;
        return $query->whereBetween('date', [$startDate, $endDate]);
    }
}