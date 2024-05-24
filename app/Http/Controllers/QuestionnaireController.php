<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Questionnaire;
use Illuminate\Support\Facades\Auth;

class QuestionnaireController extends Controller
{
    /**
     * Display the questionnaire.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('questionnaire.index');
    }

    /**
     * Store the questionnaire answers.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            // Define your validation rules here
        ]);

        // Retrieve the currently authenticated user
        $user = Auth::user();

        // Create a new questionnaire record for the user
        $questionnaire = new Questionnaire();
        // Fill the questionnaire answers from the request data
        // For example:
        // $questionnaire->answer1 = $validatedData['answer1'];
        // $questionnaire->answer2 = $validatedData['answer2'];
        // ...
        // $questionnaire->save();

        // Associate the questionnaire with the user
        $user->questionnaire()->save($questionnaire);

        // Redirect back to the dashboard with a success message
        return redirect()->route('dashboard')->with('success', 'Questionnaire submitted successfully!');
    }
}
