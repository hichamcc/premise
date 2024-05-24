<?php
namespace App\Http\Controllers;


use App\Models\Diet;
use App\Models\DietPlan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class DietPlanController extends Controller
{
    public function generateDietPlans()
    {
        $user = Auth::user();
        $questionnaire = $user->questionnaire;

        // Check if the questionnaire exists and has calories
        if (!$questionnaire || !$questionnaire->calories) {
            return redirect()->route('dashboard')->with('error', 'Please complete your questionnaire first.');
        }

        $calories = $questionnaire->calories;

        // Find diets close to the user's calorie requirement
        $diets = Diet::whereBetween('calories', [$calories * 0.9, $calories * 1.1])->get();

        if ($diets->isEmpty()) {
            return redirect()->route('dashboard')->with('error', 'No suitable diet plans found. Please try again later.');
        }

        $dates = collect(range(0, 2))->map(fn($i) => now()->addDays($i)->toDateString());

        // Get existing diet plans for the user for the next 3 days
        $existingPlans = $user->dietPlans()->whereIn('day', $dates)->get()->keyBy('day');

        // If there are fewer than 3 diets, allow repetition
        if ($diets->count() < 3) {
            foreach ($dates as $date) {
                // Randomly pick a diet
                $diet = $diets->random();

                // Check if a diet plan already exists for this day
                if (!$existingPlans->has($date)) {
                    DietPlan::create([
                        'user_id' => $user->id,
                        'diet_id' => $diet->id,
                        'day' => $date,
                    ]);
                }
            }
        } else {
            // Ensure no repetition when there are enough diets
            $shuffledDiets = $diets->shuffle();
            $previousDiets = $existingPlans->pluck('diet_id')->all();

            foreach ($dates as $index => $date) {
                // Check if a diet plan already exists for this day
                if (!$existingPlans->has($date)) {
                    // Pick a diet that is different from the previous 2 if possible
                    $availableDiets = $shuffledDiets->reject(fn($diet) => in_array($diet->id, $previousDiets))->values();

                    if ($availableDiets->isEmpty()) {
                        // If no different diet is available, allow repetition
                        $diet = $shuffledDiets->first();
                    } else {
                        $diet = $availableDiets->random();
                    }

                    // Add this diet to the list of previous diets
                    array_push($previousDiets, $diet->id);
                    if (count($previousDiets) > 2) {
                        array_shift($previousDiets); // Keep only the last 2
                    }

                    DietPlan::create([
                        'user_id' => $user->id,
                        'diet_id' => $diet->id,
                        'day' => $date,
                    ]);
                }
            }
        }

        return redirect()->route('dashboard')->with('message', 'Diet plans generated successfully for the next 3 days.');
    }
}
