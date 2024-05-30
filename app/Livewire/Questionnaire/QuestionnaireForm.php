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
// Properties for text inputs
    public $left_arm_circumference;
    public $waist_circumference;
    public $hip_circumference;
    public $chest_circumference;

    public $questions = [
        'genre' => ['required'=>'true','label' => 'SELEZIONA IL TUO GENERE', 'type' => 'select', 'options' => ['Maschio', 'Femmina'] ],
        'physical_activity' => ['required'=>'true','label' => 'QUAL E’ IL TUO LIVELLO DI ATTIVITA’ FISICA?', 'type' => 'select', 'options' => ['SEDENTARIO: faccio attività fisica meno di 2 volte al mese', 'MODERATO: faccio attività fisica circa 2 volte a settimana', 'ATTIVO: faccio attività fisica più di 2 volte a settimana']],
        'goal' => ['required'=>'true','label' => 'QUAL E’ IL TUO OBIETTIVO?', 'type' => 'select', 'options' => ['PERDERE PESO', 'AUMENTARE LA MASSA MUSCOLARE', 'ADOTTARE UNO STILE DI VITA SANO']],
        'target_zones' => ['label' => 'QUALI SONO LE TUE ZONE TARGET?', 'type' => 'checkbox' , 'options'=>['BRACCIA','PETTORALI','ADDOMINALI','GAMBE','SCHIENA']],
        'walks_frequency' => ['label' => 'QUANTO SPESSO FAI DELLE PASSEGGIATE?', 'type' => 'select' , 'options'=>['OGNI GIORNO' , '1-2 VOLTE A SETTIMANA' , '3-4 VOLTE A SETTIMANA']],
        'habits' => ['label' => 'QUALE AFFERMAZIONE DESCRIVE MEGLIO LE TUE ABITUDINI?', 'type' => 'select' , 'options'=>['MANGIO MALE' , 'LA MIA DIETA HA BISOGNO DI MIGLIORAMENTI' , 'HO DELLE SANE ABITUDINI']],
        'meals_per_day' => ['label' => 'HOW MANY TIMES A DAY DO YOU WANT TO EAT?', 'type' => 'select', 'options' => ['2: Lunch and dinner', '3: Breakfast, lunch and dinner', '4: Breakfast, lunch, snack, dinner', '5: Breakfast, mid-morning snack, lunch, snack, dinner']],
        'sleep_hours_per_night' => ['label' => 'QUANTE ORE DORMI A NOTTE?', 'type' => 'select' , 'options'=>['MENO DI 5 ORE' , '5-8 ORE' , "PIU' DI 8 ORE"]],
        'water_consumption' => ['label' => 'QUANTA ACQUA BEVI DURANTE IL GIORNO?', 'type' => 'select' , 'options'=>['MENO DI 1 L' , 'CIRCA 1.5 L' , "PIU' DI 1.5 L"]],
        'age' => [
            'required' => 'true',
            'label' => 'INSERISCI LA TUA ETA',
            'type' => 'number',
            'placeholder' => 'Anni',
            'min' => 1,
            'max' => 120
        ],
        'current_weight' => [
            'required' => 'true',
            'label' => 'INSERISCI IL TUO PESO ATTUALE',
            'type' => 'number',
            'placeholder' => 'KG',
            'min' => 10,
            'max' => 200
        ],
        'height' => [
            'required' => 'true',
            'label' => 'INSERISCI LA TUA ALTEZZA',
            'type' => 'number',
            'placeholder' => 'CM',
            'min' => 40,
            'max' => 220
        ],
        'desired_weight' => [
            'required' => 'true',
            'label' => 'INSERISCI IL TUO PESO DESIDERATO',
            'type' => 'number',
            'placeholder' => 'KG',
            'min' => 20,
            'max' => 150
        ], 'calculation_choice' => ['label' => '', 'type' => 'checkbox' , 'options'=>[]],
        'vegetables_not_eaten' => ['label' => 'SELEZIONA LE VERDURE CHE NON MANGI', 'type' => 'checkbox','options'=>['ZUCCHINE' , 'POMODORI' , 'CARCIOFI' , 'CETRIOLI' , 'MELANZANE']],
        'fruits_not_eaten' => ['label' => 'SELEZIONA LA FRUTTA CHE NON MANGI', 'type' => 'checkbox' , 'options'=>['FRAGOLE' , 'CILIEGIE' , 'NESPOLE' , 'ALBICOCCHE',' PESCHE' ]],
        'oilseeds_not_eaten' => ['label' => 'SELEZIONA I SEMI OLEOSI CHE NON MANGI', 'type' => 'checkbox' , 'options'=>['ARACHIDI' , 'ANACARDI' , 'NOCCIOLE' , 'NOCI' , 'PISTACCHI']],
        'legumes_not_eaten' => ['label' => 'SELEZIONA I LEGUMI CHE NON MANGI', 'type' => 'checkbox','options'=>['CECI' , 'FAVE' , 'FAGIOLI' , 'LENTICCHIE' ,'PISELLI' ]],
        'dairy_products_not_eaten' => ['label' => 'SELEZIONA I LATTICINI CHE NON MANGI', 'type' => 'checkbox' , 'options'=>['FIOCCHI DI LATTE' , 'PHILADELPHIA LIGHT' , 'RICOTTA' , 'MOZZARELLA' , 'LATTE']],
        'meat_not_eaten' => ['label' => 'SELEZIONA LA CARNE CHE NON MANGI', 'type' => 'checkbox' , 'options'=>['AGNELLO' , 'MANZO' , 'TACCHINO' , 'POLLO' , 'CONIGLIO']],
        'fish_not_eaten' => ['label' => 'SELEZIONA IL PESCE CHE NON MANGI', 'type' => 'checkbox' , 'options'=>['MERLUZZO','PESCE SPADA'  , 'TONNO','SALMONE','SPIGOLA']],
       // 'intolerances_or_allergies' => ['label' => 'DO YOU HAVE ONE OR MORE OF THESE INTOLERANCES AND/OR ALLERGIES?', 'type' => 'checkbox','options'=>['LACTOSE INTOLERANCE','GLUTEN INTOLERANCE','EGG ALLERGY','PEANUT ALLERGY','CRUSTACEANS ALLERGY']],
        //'diseases_diagnosed_by_doctor' => ['label' => 'DO YOU HAVE ANY OF THESE DISEASES? (diagnosed by a doctor)', 'type' => 'checkbox','options'=>['DYSLIPIDEMIA','DIABETES MELLITUS TYPE 2' , 'GASTRITIS AND/OR ESOPHAGITIS' , 'GASTROESOPHAGEAL REFLUX' , 'HYPERTENSION' ]],
       // 'left_arm_circumference' => ['label' => 'Left Arm Circumference', 'type' => 'text', 'placeholder'=>'CM'],
       // 'waist_circumference' => ['label' => 'Waist Circumference', 'type' => 'text', 'placeholder'=>'CM'],
       // 'hip_circumference' => ['label' => 'Hip Circumference', 'type' => 'text', 'placeholder'=>'CM'],
       // 'chest_circumference' => ['label' => 'Chest Circumference', 'type' => 'text', 'placeholder'=>'CM'],
       // 'front_photo' => ['label' => 'Front Photo', 'type' => 'file'],
       // 'side_photos' => ['label' => 'Side Photos', 'type' => 'file'],
       // 'back_photo' => ['label' => 'Back Photo', 'type' => 'file'],
    ];

    //dashboard” button to go back to the dashboard



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
        //'intolerances_or_allergies',
        //'diseases_diagnosed_by_doctor',
        //'left_arm_circumference',
        //'waist_circumference',
        //'hip_circumference',
        //'chest_circumference',
        //'front_photo',
        //'side_photos',
        //'back_photo',
    ];


    public function mount()
    {
        $userId = Auth::id();
        $questionnaire = Questionnaire::where('user_id', $userId)->first();

        if ($questionnaire) {

            $this->answered = true;
       }

        $this->answers['left_arm_circumference'] = '';
        $this->answers['waist_circumference'] = '';
        $this->answers['hip_circumference'] = '';
        $this->answers['chest_circumference'] = '';
    }

    public function nextQuestion()
    {
        $currentQuestionKey = $this->questionKeys[$this->currentQuestionIndex];
        $isRequired = $this->questions[$currentQuestionKey]['required'] ?? false;

        if ($isRequired && empty($this->answers[$currentQuestionKey])) {
            $this->errorMessage = 'This question is required.';
            return;
        }


        // Check if the question is of type number and validate min and max constraints
        if ($this->questions[$currentQuestionKey]['type'] === 'number') {
            $min = $this->questions[$currentQuestionKey]['min'] ?? null;
            $max = $this->questions[$currentQuestionKey]['max'] ?? null;
            $answer = $this->answers[$currentQuestionKey];

            if (($min !== null && $answer < $min) || ($max !== null && $answer > $max)) {
                $this->errorMessage = "Inserisci un valore compreso tra $min e $max.";
                return;
            }
        }

        $this->errorMessage = ''; // Clear error message
        $i = 1 ;
        if( $this->currentQuestionIndex == 23 ) {
            $i = 4;
        }
        if( $this->currentQuestionIndex == 27 ) {
            $i =3;
        }

        if( $this->currentQuestionIndex == 5 ) {
            $i =2;
        }
        $this->currentQuestionIndex = $this->currentQuestionIndex+$i ;

        if ($this->currentQuestionIndex >= count($this->questions)) {
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
                $this->bmiMessage = "indicando una condizione di obesità , una condizione che può essere migliorata con un po' di impegno";
            } elseif ($this->bmi > 25 && $this->bmi <= 30) {
                $this->bmiMessage = "indicando una condizione di sovrappeso, una condizione che può essere migliorata con un po' di impegno";

            } elseif ($this->bmi > 18.5 && $this->bmi <= 24.9) {
                $this->bmiMessage = "indicando una condizione di peso normale , una condizione che può essere migliorata con un po' di impegno";

            } else {
                $this->bmiMessage = "indicando una condizione di sottopeso , una condizione che può essere migliorata con un po' di impegno";

            }
        }

        // Calculate Metabolism
        if (isset($this->answers['current_weight']) && isset($this->answers['height']) && isset($this->answers['age']) && isset($this->answers['genre'])) {
            $weight = $this->answers['current_weight'];
            $height = $this->answers['height'];
            $age = $this->answers['age'];
            $genre = $this->answers['genre'];

            // Calculate Ideal Weight
            $idealWeight = ($genre == 'Maschio') ? (($height / 100) ** 2) * 22.1 : (($height / 100) ** 2) * 20.6;

            if ($genre == 'Maschio') {
                $this->metabolism = 66 + (13.7 * $weight) + (5 * $height) - (6.8 * $age);
            } else {
                $this->metabolism = 65 + (9.6 * $weight) + (1.8 * $height) - (4.7 * $age);
            }

            // Calculate Calories based on physical activity
            $activityLevel = $this->answers['physical_activity'] ?? '';
            if (strpos($activityLevel, 'SEDENTARIO') !== false) {
                $this->calories = ($this->metabolism * 1.05) - 500;
            } elseif (strpos($activityLevel, 'MODERATO') !== false) {
                $this->calories = ($this->metabolism * 1.15) - 500;
            } elseif (strpos($activityLevel, 'ATTIVO') !== false) {
                $this->calories = ($this->metabolism * 1.25) - 500;
            }


            $this->metabolism = number_format($this->metabolism, 2);

        }


    }



    public function storeQuestionnaire()
    {
        // Validate the file inputs
        $this->validate([
            'front_photo' => 'nullable|image|max:10240', // 10MB max
            'side_photos' => 'nullable|image|max:10240', // 10MB max
            'back_photo' => 'nullable|image|max:10240', // 10MB max
        ]);

        // Validate the text inputs
        $this->validate([
            'answers.left_arm_circumference' => 'nullable|string',
            'answers.waist_circumference' => 'nullable|string',
            'answers.hip_circumference' => 'nullable|string',
            'answers.chest_circumference' => 'nullable|string',
        ]);

        // Validate text inputs
        $this->validate([
            'left_arm_circumference' => 'nullable|string',
            'waist_circumference' => 'nullable|string',
            'hip_circumference' => 'nullable|string',
            'chest_circumference' => 'nullable|string',
        ]);

        // Prepare data array for text inputs

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
            $data['side_photos'] = $this->side_photos->store('photos', 'public');
        }

        if ($this->back_photo) {
            $data['back_photo'] = $this->back_photo->store('photos', 'public');
        }

        $data['left_arm_circumference'] = $this->left_arm_circumference;
        $data['waist_circumference'] = $this->waist_circumference;
        $data['hip_circumference'] = $this->hip_circumference;
        $data['chest_circumference'] = $this->chest_circumference;

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
