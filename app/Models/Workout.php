<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'video' , 'difficulty' , 'day'];

    public static function getWorkoutForToday()
    {
        // Get the current day of the week (e.g., "Monday")
        $currentDay = Carbon::now()->format('l');

        // Find the workout for the current day
        $workout = self::where('day', $currentDay)->inRandomOrder()->first();

        return $workout ? $workout->video : null;
    }
}
