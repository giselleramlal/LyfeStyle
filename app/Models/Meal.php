<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'description',
        'calories',
        'protein',
        'carbs',
        'fat',
        'daily_log_id'
    ];

    protected $casts = [
        'calories' => 'decimal:2',
        'protein' => 'decimal:2',
        'carbs' => 'decimal:2',
        'fat' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dailyLog()
    {
        return $this->belongsTo(DailyLog::class);
    }

    // Scope for current user
    public function scopeForUser($query, $userId = null)
    {
        $userId = $userId ?: auth()->id();
        return $query->where('user_id', $userId);
    }

    // Scope by meal type
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}