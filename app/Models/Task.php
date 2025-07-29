<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'daily_log_id',
        'description',
        'is_completed',
    ];

    protected $casts = [
        'is_completed' => 'boolean', // corrected to match actual column name
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
