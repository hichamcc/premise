<?php


namespace App\Http\Controllers;

use App\Models\DietPlan;
use App\Models\Workout;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Questionnaire;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $hasAnsweredQuestionnaire = Questionnaire::where('user_id', $user->id)->exists();

        return view('dashboard', ['hasAnsweredQuestionnaire' => $hasAnsweredQuestionnaire]);
    }

    public function diets()
    {
        $user = Auth::user();
        $hasAnsweredQuestionnaire = Questionnaire::where('user_id', $user->id)->exists();

        if ($hasAnsweredQuestionnaire) {
            // Get today's date
            $today = Carbon::today();

            // Get the diet plans for the next 3 days including today
            $dietPlans = DietPlan::where('user_id', $user->id)
                ->whereBetween('day', [$today, $today->copy()->addDays(2)])
                ->with('diet') // Assuming there's a 'diet' relation on DietPlan model
                ->orderBy('day')
                ->get();
        } else {
            $dietPlans = collect(); // Empty collection if the user hasn't answered the questionnaire
        }

        return view('diets.index',
            ['hasAnsweredQuestionnaire' => $hasAnsweredQuestionnaire ,
                'dietPlans' => $dietPlans
            ]);
    }

    public function workouts()
    {
        $user = Auth::user();
        $hasAnsweredQuestionnaire = Questionnaire::where('user_id', $user->id)->exists();
        $workoutVideo = Workout::getWorkoutForToday();

        return view('workouts.index',
            [
                'hasAnsweredQuestionnaire' => $hasAnsweredQuestionnaire ,
                'workoutVideo' => $workoutVideo,
            ]);
    }
}
