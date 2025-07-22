<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyLog extends Model
{
    protected $fillable = ['user_id', 'date'];

    public function meals() {
        return $this->hasMany(Meal::class);
    }

    public function habits() {
        return $this->hasMany(Habit::class);
    }

    public function workout() {
        return $this->hasOne(Workout::class);
    }

    public function sleepLog() {
        return $this->hasOne(SleepLog::class);
    }

    public function waterIntake() {
        return $this->hasOne(WaterIntake::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}

