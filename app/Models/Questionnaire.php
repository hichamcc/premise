<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questionnaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'genre',
        'physical_activity',
        'goal',
        'target_zones',
        'walks_frequency',
        'habits',
        'meals_per_day',
        'sleep_hours_per_night',
        'water_consumption',
        'age',
        'current_weight',
        'height',
        'desired_weight',
        'calculation_choice',
        'vegetables_not_eaten',
        'fruits_not_eaten',
        'oilseeds_not_eaten',
        'legumes_not_eaten',
        'dairy_products_not_eaten',
        'meat_not_eaten',
        'fish_not_eaten',
        'intolerances_or_allergies',
        'diseases_diagnosed_by_doctor',
        'left_arm_circumference',
        'waist_circumference',
        'hip_circumference',
        'chest_circumference',
        'front_photo',
        'side_photos',
        'back_photo',
        'calories'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
