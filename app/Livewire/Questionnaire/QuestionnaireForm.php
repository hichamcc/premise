<?php

namespace App\Livewire\Questionnaire;

use App\Models\Questionnaire;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class QuestionnaireForm extends Component
{

    use WithFileUploads;

    public $currentQuestionIndex = 0;
    public $answers = [];
    public $specialStep = [] ;
    public $errorMessage = '';
    public $bmi = null;
    public $bmiMessage = '';
    public $metabolism = null;
    public $calories = null;
    public $answered = false ;
    public $front_photo;
    public $side_photos;
    public $back_photo;


    public $questions = [
        'genre' => ['required'=>'true','label' => 'SELECT YOUR GENRE', 'type' => 'select', 'options' => ['Male', 'Female'] ],
        'physical_activity' => ['required'=>'true','label' => 'WHAT IS YOUR LEVEL OF PHYSICAL ACTIVITY?', 'type' => 'select', 'options' => ['SEDENTARY: I exercise less than 2 time', 'MODERATE: I exercise about 2 times a week', 'ACTIVE: I exercise more than 2 times a week']],
        'goal' => ['required'=>'true','label' => 'WHAT IS YOUR GOAL?', 'type' => 'select', 'options' => ['LOSE WEIGHT', 'INCREASING MUSCLE MASS', 'ADOPT A HEALTHY LIFESTYLE']],
        'target_zones' => ['label' => 'WHAT ARE YOUR TARGET ZONES?', 'type' => 'checkbox' , 'options'=>['ARMS','BIBS','ABDOMINAL','LEGS','BACK']],
        'walks_frequency' => ['label' => 'HOW OFTEN DO YOU GO FOR WALKS?', 'type' => 'select' , 'options'=>['EVERYDAY' , '1-2 TIMES A WEEK' , '3-4 TIMES A WEEK']],
        'habits' => ['label' => 'WHICH STATEMENT BEST DESCRIBES YOUR HABITS?', 'type' => 'select' , 'options'=>['I EAT BAD' , 'MY DIET NEEDS IMPROVEMENT' , 'I HAVE HEALTHY HABITS']],
        'meals_per_day' => ['label' => 'HOW MANY TIMES A DAY DO YOU WANT TO EAT?', 'type' => 'select', 'options' => ['2: Lunch and dinner', '3: Breakfast, lunch and dinner', '4: Breakfast, lunch, snack, dinner', '5: Breakfast, mid-morning snack, lunch, snack, dinner']],
        'sleep_hours_per_night' => ['label' => 'HOW MANY HOURS DO YOU SLEEP PER NIGHT?', 'type' => 'select' , 'options'=>['LESS THAN 5 HOURS' , '5-8 HOURS' , 'MORE THAN 8 HOURS']],
        'water_consumption' => ['label' => 'HOW MUCH WATER DO YOU DRINK DURING THE DAY?', 'type' => 'select' , 'options'=>['LESS THAN 1 L' , 'ABOUT 1.5 L' , 'MORE THAN 1.5 L']],
        'age' => ['required'=>'true','label' => 'ENTER YOUR AGE', 'type' => 'text' , 'placeholder'=>'Years'],
        'current_weight' => ['required'=>'true','label' => 'ENTER YOUR CURRENT WEIGHT', 'type' => 'text', 'placeholder'=>'KG'],
        'height' => ['required'=>'true','label' => 'ENTER YOUR HEIGHT', 'type' => 'text' , 'placeholder'=>'CM'],
        'desired_weight' => ['required'=>'true','label' => 'ENTER YOUR DESIRED WEIGHT', 'type' => 'text', 'placeholder'=>'KG'],
        'calculation_choice' => ['required'=>'true','label' => 'CALCULATIONS AND WRITING:', 'type' => 'select' , 'options'=>['I KEEP THIS CHOICE' , 'I NEED TO SPEED UP THE PROCESS']],
        'vegetables_not_eaten' => ['label' => 'SELECT THE VEGETABLES YOU DON\'T EAT', 'type' => 'checkbox','options'=>['ZUCHINIS' , 'TOMATOES' , 'ARTICHOKES' , 'CUCUMBERS' , 'EGGPLANT']],
        'fruits_not_eaten' => ['label' => 'SELECT THE FRUIT YOU DON\'T EAT', 'type' => 'checkbox' , 'options'=>['STRAWBERRIES' , 'APPLE' , 'PEARS' , 'BANANA',' ORANGES' ]],
        'oilseeds_not_eaten' => ['label' => 'SELECT THE OILSEEDS YOU DON\'T EAT', 'type' => 'checkbox' , 'options'=>['PEANUTS' , 'CASHEW NUTS' , 'HAZELNUTS' , 'NUTS' , 'PISTACHIOS']],
        'legumes_not_eaten' => ['label' => 'SELECT THE LEGUMES YOU DON\'T EAT', 'type' => 'checkbox','options'=>['CHICKPEAS' , 'FAVA BEANS' , 'BEANS' , 'LENTILS' ,'PEAS' ]],
        'dairy_products_not_eaten' => ['label' => 'SELECT THE DAIRY PRODUCTS YOU DON\'T EAT', 'type' => 'checkbox' , 'options'=>['COTTAGE CHEESE' , 'PHILADELPHIA LIGHT' , 'RICOTTA' , 'MOZZARELLA CHEESE' , 'MILK']],
        'meat_not_eaten' => ['label' => 'SELECT THE MEAT YOU DON\'T EAT', 'type' => 'checkbox' , 'options'=>['LAMB' , 'HORSE' , 'BEEF' , 'CHICKEN' , 'RABBIT']],
        'fish_not_eaten' => ['label' => 'SELECT THE FISH YOU DON\'T EAT', 'type' => 'checkbox' , 'options'=>['SQUID','SWORDFISH'  , 'TUNA','SALMON','SALMON SEA BASS (BASS)']],
        'intolerances_or_allergies' => ['label' => 'DO YOU HAVE ONE OR MORE OF THESE INTOLERANCES AND/OR ALLERGIES?', 'type' => 'checkbox','options'=>['LACTOSE INTOLERANCE','GLUTEN INTOLERANCE','EGG ALLERGY','PEANUT ALLERGY','CRUSTACEANS ALLERGY']],
        'diseases_diagnosed_by_doctor' => ['label' => 'DO YOU HAVE ANY OF THESE DISEASES? (diagnosed by a doctor)', 'type' => 'checkbox','options'=>['DYSLIPIDEMIA','DIABETES MELLITUS TYPE 2' , 'GASTRITIS AND/OR ESOPHAGITIS' , 'GASTROESOPHAGEAL REFLUX' , 'HYPERTENSION' ]],
        'left_arm_circumference' => ['label' => 'Left Arm Circumference', 'type' => 'text', 'placeholder'=>'CM'],
        'waist_circumference' => ['label' => 'Waist Circumference', 'type' => 'text', 'placeholder'=>'CM'],
        'hip_circumference' => ['label' => 'Hip Circumference', 'type' => 'text', 'placeholder'=>'CM'],
        'chest_circumference' => ['label' => 'Chest Circumference', 'type' => 'text', 'placeholder'=>'CM'],
        'front_photo' => ['label' => 'Front Photo', 'type' => 'file'],
        'side_photos' => ['label' => 'Side Photos', 'type' => 'file'],
        'back_photo' => ['label' => 'Back Photo', 'type' => 'file'],
    ];

    public $questionKeys = [
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
    ];


    public function mount()
    {
        $userId = Auth::id();
        $questionnaire = Questionnaire::where('user_id', $userId)->first();

        if ($questionnaire) {

            $this->answered = true;
       }

        // Initialize questions, if necessary
    }

    public function nextQuestion()
    {
        $currentQuestionKey = $this->questionKeys[$this->currentQuestionIndex];
        $isRequired = $this->questions[$currentQuestionKey]['required'] ?? false;

        if ($isRequired && empty($this->answers[$currentQuestionKey])) {
            $this->errorMessage = 'This question is required.';
            return;
        }

        $this->errorMessage = ''; // Clear error message
        $i = 1 ;
        if( $this->currentQuestionIndex == 23 ) {
            $i = 4;
        }
        if( $this->currentQuestionIndex == 27 ) {
            $i =3;
        }
        $this->currentQuestionIndex = $this->currentQuestionIndex+$i ;

        if ($this->currentQuestionIndex >= count($this->questionKeys)) {
            $this->storeQuestionnaire();
        }

        // Calculate BMI when both current_weight and height are provided
        if (isset($this->answers['current_weight']) && isset($this->answers['height'])) {
            $weight = $this->answers['current_weight'];
            $height = $this->answers['height'];
            $this->bmi = $weight / (($height / 100) ** 2);
            $this->bmi = number_format($this->bmi, 2);

            // Interpret BMI
            if ($this->bmi > 30) {
                $this->bmiMessage = "Your body mass index depicts an obese condition.";
            } elseif ($this->bmi > 25 && $this->bmi <= 30) {
                $this->bmiMessage = "Your body mass index depicts an overweight condition.";
            } elseif ($this->bmi > 18.5 && $this->bmi <= 24.9) {
                $this->bmiMessage = "Your body mass index depicts a normal-weight condition.";
            } else {
                $this->bmiMessage = "Your body mass index depicts an underweight condition.";
            }
        }

        // Calculate Metabolism
        if (isset($this->answers['current_weight']) && isset($this->answers['height']) && isset($this->answers['age']) && isset($this->answers['genre'])) {
            $weight = $this->answers['current_weight'];
            $height = $this->answers['height'];
            $age = $this->answers['age'];
            $genre = $this->answers['genre'];

            // Calculate Ideal Weight
            $idealWeight = ($genre == 'Male') ? (($height / 100) ** 2) * 22.1 : (($height / 100) ** 2) * 20.6;

            if ($genre == 'Male') {
                $this->metabolism = 66 + (13.7 * $weight) + (5 * $height) - (6.8 * $age);
            } else {
                $this->metabolism = 65 + (9.6 * $weight) + (1.8 * $height) - (4.7 * $age);
            }

            // Calculate Calories based on physical activity
            $activityLevel = $this->answers['physical_activity'] ?? '';
            if (strpos($activityLevel, 'SEDENTARY') !== false) {
                $this->calories = ($this->metabolism * 1.05) - 500;
            } elseif (strpos($activityLevel, 'MODERATE') !== false) {
                $this->calories = ($this->metabolism * 1.15) - 500;
            } elseif (strpos($activityLevel, 'ACTIVE') !== false) {
                $this->calories = ($this->metabolism * 1.25) - 500;
            }


            $this->metabolism = number_format($this->metabolism, 2);

        }


    }



    public function storeQuestionnaire()
    {
        $this->validate([
            'answers.front_photo' => 'nullable|image|max:10240', // 10MB max
            'answers.side_photos' => 'nullable|image|max:10240', // 10MB max
            'answers.back_photo' => 'nullable|image|max:10240', // 10MB max
        ]);

        $data = [];
        foreach ($this->questionKeys as $key) {
            if (isset($this->answers[$key])) {
                if ($this->questions[$key]['type'] === 'checkbox') {
                    // Get the option values for the selected options
                    $selectedOptions = [];
                    foreach ($this->answers[$key] as $index => $value) {
                        if ($value) {
                            $selectedOptions[] = $this->questions[$key]['options'][$index];
                        }
                    }
                    // Concatenate the selected options into a single string
                    $data[$key] = implode(' - ', $selectedOptions);
                } else {
                    $data[$key] = preg_replace('/[\s,]+/', ' ', trim($this->answers[$key]));
                }
            } else {
                $data[$key] = null;
            }
        }

        $data['user_id'] = Auth::id();


        $data['calories'] = (int)$this->calories;

        if ($this->front_photo) {
            $data['front_photo'] = $this->front_photo->store('photos', 'public');
        }

        if ($this->side_photos) {
            $data['side_photos'] = $this->side_photo->store('photos', 'public');
        }

        if ($this->back_photo) {
            $data['back_photo'] = $this->back_photo->store('photos', 'public');
        }


        Questionnaire::create($data);

        // Run the artisan command
        Artisan::call('diet:generate');

        session()->flash('message', 'Questionnaire submitted successfully.');

        //return redirect()->route('dashboard');
    }


    public function render()
    {

        $this->specialStep = [
            23,// step for the 4 circumferences
            27, // step for the 3 photos
            24,25,26,27,28,29
        ];


        $key = $this->questionKeys[$this->currentQuestionIndex] ?? null;
        return view('livewire.Questionnaire.questionnaire-form', [
            'currentQuestion' => isset($this->questions[$key]) ? $this->questions[$key] : null,
            'totalQuestions' => count($this->questions),
        ]);
    }
}
