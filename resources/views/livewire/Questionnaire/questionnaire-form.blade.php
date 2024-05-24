<div class="">

    @if(!$answered)
    <div class="mt-4 overflow-hidden rounded-full bg-gray-200">
        <div class="h-2 rounded-full bg-blue-700" style="width: {{ ($currentQuestionIndex + 1) / $totalQuestions * 100 }}%"></div>
    </div>

    <div class="mt-4 min-h-[600px] text-center">
        @if ($currentQuestion && !in_array($currentQuestionIndex, $specialStep) )
            <p class="text-4xl font-medium text-blue-700 text-center mt-8">{{ $currentQuestion['label'] }}</p>
        @endif
            @if ($bmi && $currentQuestionIndex == 13)
                <div class="mt-4 text-2xl font-semibold text-center">
                    Your BMI: {{ $bmi }}
                    <p>{{ $bmiMessage }}</p>
                </div>
            @endif
            @if ($metabolism && $currentQuestionIndex == 13)
                <div class="mt-4 text-2xl font-semibold text-center">
                    Your Metabolism: {{ $metabolism }} kcal/day
                    <br>
                </div>

            @endif
        @if ($currentQuestion )
            <div class="min-h-[500px] content-center">
                @if ($errorMessage)
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">{{ $errorMessage }}</span>
                    </div>
                @endif

                @if ($currentQuestion['type'] === 'select' && !in_array($currentQuestionIndex, $specialStep) )
                    <ul class="grid w-full gap-6 md:grid-cols-2">
                        @foreach ($currentQuestion['options'] as $option)
                            <li>
                                <input wire:click="nextQuestion"  wire:model="answers.{{ $questionKeys[$currentQuestionIndex] }}" type="radio" id="{{ preg_replace('/\s+/', '', $option) }}" name="{{ $questionKeys[$currentQuestionIndex] }}" value="{{ $option }}" class="hidden peer" required />
                                <label for="{{ preg_replace('/\s+/', '', $option) }}" class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-2xl cursor-pointer peer-checked:border-blue-600 peer-checked:text-white peer-checked:bg-gradient-to-r peer-checked:from-blue-700 peer-checked:to-blue-400 hover:text-gray-600 hover:bg-gray-100">
                                    <div class="block">
                                        <div class="w-full text-lg font-semibold">{{ $option }}</div>
                                    </div>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                @elseif ($currentQuestion['type'] === 'checkbox' && !in_array($currentQuestionIndex, $specialStep) )
                    <ul class="grid w-full gap-6 md:grid-cols-2">
                        @foreach ($currentQuestion['options'] as $option)
                            <li>
                                <input wire:model="answers.{{ $questionKeys[$currentQuestionIndex] }}.{{ $loop->index }}" type="checkbox" id="{{ $questionKeys[$currentQuestionIndex] }}_{{ $loop->index }}" name="{{ $questionKeys[$currentQuestionIndex] }}[]" value="{{ $option }}" class="hidden peer" />
                                <label for="{{ $questionKeys[$currentQuestionIndex] }}_{{ $loop->index }}" class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-2xl cursor-pointer peer-checked:border-blue-600 peer-checked:text-white peer-checked:bg-gradient-to-r peer-checked:from-blue-700 peer-checked:to-blue-400 hover:text-gray-600 hover:bg-gray-100">
                                    <div class="block">
                                        <div class="w-full text-lg font-semibold">{{ $option }}</div>
                                    </div>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                @elseif ($currentQuestion['type'] === 'text' && !in_array($currentQuestionIndex, $specialStep) )
                    <input type="text" wire:model="answers.{{ $questionKeys[$currentQuestionIndex] }}" name="{{ $questionKeys[$currentQuestionIndex] }}" id="{{ $questionKeys[$currentQuestionIndex] }}" class="mt-2 block w-1/2 mx-auto h-[100px] text-xl px-4 py-2 rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0" placeholder="{{ $currentQuestion['placeholder'] ?? 'Enter your answer' }}">
                @elseif ($currentQuestion['type'] === 'file' && !in_array($currentQuestionIndex, $specialStep) )
                    <input type="file" wire:model="answers.{{ $questionKeys[$currentQuestionIndex] }}" name="{{ $questionKeys[$currentQuestionIndex] }}" id="{{ $questionKeys[$currentQuestionIndex] }}" class="mt-2 block w-1/2 px-4 py-2 rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0">
                @endif

                {{-- Special Step for Circumferences --}}
                @if ($currentQuestionIndex == $specialStep[0])
                        <p class="text-4xl font-medium text-blue-700 text-center mt-8">TO MONITOR PROGRESS...</p>
                        <p class="text-4xl font-medium text-blue-700 text-center mt-8 mb-4"> ENTER YOUR CIRCUMFERENCES</p>
                    <div class="step">
                        @foreach (['left_arm_circumference', 'waist_circumference', 'hip_circumference', 'chest_circumference'] as $keya)
                            <div class="flex gap-2 items-center mb-2">
                                <label class="w-1/2 text-xl">{{ $questions[$keya]['label'] }}</label>
                                <input class="w-1/2 mt-2 block w-1/2 mx-auto h-[50px] text-xl px-4 py-2 rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0" type="text" name="{{ $keya}}" id="{{ $keya}}" wire:model.defer="{{ $keya }}" placeholder="{{ $questions[$keya]['placeholder'] }}">
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Special Step for Photos --}}
                @if ($currentQuestionIndex == $specialStep[1])
                        <p class="text-4xl font-medium text-blue-700 text-center mt-8">TO MONITOR PROGRESS...</p>
                        <p class="text-4xl font-medium text-blue-700 text-center mt-8 mb-4"> INSERT YOUR CURRENT PHOTOS</p>
                        <div class="step">
                            @foreach (['front_photo', 'side_photos', 'back_photo'] as $key)
                                <div class="flex gap-2 items-center mb-2">
                                    <label class="w-1/2 text-xl">{{ $questions[$key]['label'] }}</label>
                                    <input class="  mt-2 block w-1/2 px-4 py-2 rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0" type="file" name="{{ $key }}" id="{{$key}}" wire:model.defer="{{ $key }}">
                                </div>
                            @endforeach
                        </div>
                        <p class="text-md text-gray-600">IT'S NOT MANDATORY, IF YOU DON'T FEEL LIKE IT YOU CAN NOT UPLOAD THEM</p>
                       <p class="text-md text-gray-600"> N. B. THEY WILL NOT BE PUBLISHED ANYWHERE</p>
                @endif
            </div>

                @if ($currentQuestion['type'] != 'select')
                    <button wire:click="nextQuestion"  class=" bottom-0 relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-blue-700 to-blue-400 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                        <span class="flex gap-2 items-center relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                            Next Step
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                            </svg>
                        </span>
                    </button>
                @endif
            @else
                    <div class="font-medium text-lg">
                        <p class=" mb-2">You will be able to consult your plan in your account. </p>
                        <p class=" mb-2">By following the diet regimen you will find in your account you should lose at least 20 pounds in three months.</p>
                        <p class=" mb-2">We aim for this result for three reasons:</p>
                        <p class=" mb-2 text-blue-600">1) All studies have shown major benefits even with weight reductions of 5%.</p>
                    <p class=" mb-2 text-blue-600">2) The slowest weight losses are the ones that are most sustained over time.</p>
                    <p class=" mb-2 text-blue-600">3) Excessive calorie reduction may be difficult to follow.</p>
                    <p class=" mb-2 ">We prefer to proceed in steps, so having reached the first goal at three months, we can continue with a more ambitious goal.”</p>

                </div>
            @endif
    </div>
    @else
        <div class="font-medium text-lg">
            <p class=" mb-2">You will be able to consult your plan in your account. </p>
            <p class=" mb-2">By following the diet regimen you will find in your account you should lose at least 20 pounds in three months.</p>
            <p class=" mb-2">We aim for this result for three reasons:</p>
            <p class=" mb-2 text-blue-600">1) All studies have shown major benefits even with weight reductions of 5%.</p>
            <p class=" mb-2 text-blue-600">2) The slowest weight losses are the ones that are most sustained over time.</p>
            <p class=" mb-2 text-blue-600">3) Excessive calorie reduction may be difficult to follow.</p>
            <p class=" mb-2 ">We prefer to proceed in steps, so having reached the first goal at three months, we can continue with a more ambitious goal.”</p>

        </div>
   @endif

</div>
