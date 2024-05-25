<?php

namespace App\Console\Commands;

use App\Models\Diet;
use App\Models\DietPlan;
use App\Models\User;
use Illuminate\Console\Command;

class GenerateDietPlans extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'diet:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate diet plans for users who have answered the questionnaire';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $this->info("Generate diet plans for users who have answered the questionnaire");

        $users = User::with('questionnaire')->get();
        foreach ($users as $user) {
            if ($user->questionnaire) {
                $this->generateDietPlans($user);
            }
        }

        return Command::SUCCESS;
    }

    private function generateDietPlans($user)
    {

        $questionnaire = $user->questionnaire;

        if (!$questionnaire || !$questionnaire->calories) {
            return;
        }

        $calories = $questionnaire->calories;
        $diets = Diet::whereBetween('calories', [$calories * 0.9, $calories * 1.1])->get();

        if ($diets->isEmpty()) {
            return;
        }

        // Generate dates for today and the next two days
        $dates = collect(range(1, 3))->map(fn($i) => now()->addDays($i)->toDateString());

        // Get existing diet plans for the specified dates
        $existingPlans = $user->dietPlans()->whereIn('day', $dates)->get()->keyBy('day');

        // Find the missing dates where diet plans need to be generated
        $missingDates = $dates->diff($existingPlans->keys());

        foreach ($missingDates as $date) {
            $shuffledDiets = $diets->shuffle();
            $previousDiets = $existingPlans->pluck('diet_id')->all();

            $availableDiets = $shuffledDiets->reject(fn($diet) => in_array($diet->id, $previousDiets))->values();

            if ($availableDiets->isEmpty()) {
                $diet = $shuffledDiets->first();
            } else {
                $diet = $availableDiets->random();
            }

            // Update previousDiets to include the new diet
            $previousDiets[] = $diet->id;
            if (count($previousDiets) > 2) {
                array_shift($previousDiets);
            }



            // Check again before creating the new diet plan for the missing date
            if (!DietPlan::where('user_id', $user->id)->where('day', $date)->exists()) {
                DietPlan::create([
                    'user_id' => $user->id,
                    'diet_id' => $diet->id,
                    'description' => $diet->description,
                    'day' => $date,
                ]);
            }
        }
    }

}
