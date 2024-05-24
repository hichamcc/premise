<?php


namespace App\Models;

// app/Models/DietPlan.php
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class DietPlan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'diet_id', 'day'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function diet()
    {
        return $this->belongsTo(Diet::class);
    }

    protected function day(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value),
        );
    }

    public function scopeUpcoming(Builder $query)
    {
        return $query->where('day', '>=', Carbon::today()->toDateString());
    }
}
