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
                    Il tuo BMI è : {{ $bmi }}
                    <p>{{ $bmiMessage }}</p>
                </div>
            @endif
            @if ($metabolism && $currentQuestionIndex == 13)
                <div class="mt-4 text-2xl font-semibold text-center hidden">
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
                    <input type="text" wire:model="answers.{{ $questionKeys[$currentQuestionIndex] }}" name="{{ $questionKeys[$currentQuestionIndex] }}" id="{{ $questionKeys[$currentQuestionIndex] }}" class="mt-2 block w-1/2 mx-auto h-[100px] text-xl px-4 py-2 rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0" placeholder="{{ $currentQuestion['placeholder'] ?? '' }}">
                  @elseif ($currentQuestion['type'] === 'number' && !in_array($currentQuestionIndex, $specialStep) )
                        <input
                            type="number"
                            wire:model="answers.{{ $questionKeys[$currentQuestionIndex] }}"
                            name="{{ $questionKeys[$currentQuestionIndex] }}"
                            id="{{ $questionKeys[$currentQuestionIndex] }}"
                            class="mt-2 block w-1/2 mx-auto h-[100px] text-xl px-4 py-2 rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"
                            placeholder="{{ $currentQuestion['placeholder'] ?? '' }}"
                            @if (isset($currentQuestion['min'])) min="{{ $currentQuestion['min'] }}" @endif
                            @if (isset($currentQuestion['max'])) max="{{ $currentQuestion['max'] }}" @endif
                        >
                    @elseif ($currentQuestion['type'] === 'file' && !in_array($currentQuestionIndex, $specialStep) )
                    <input type="file" wire:model="answers.{{ $questionKeys[$currentQuestionIndex] }}" name="{{ $questionKeys[$currentQuestionIndex] }}" id="{{ $questionKeys[$currentQuestionIndex] }}" class="mt-2 block w-1/2 px-4 py-2 rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0">
                @endif


            </div>

                @if ($currentQuestion['type'] != 'select')
                    <button wire:click="nextQuestion"  class=" bottom-0 relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-blue-700 to-blue-400 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                        <span class="flex gap-2 items-center relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                            passo successivo
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                            </svg>
                        </span>
                    </button>
                @endif
            @else
                <div class="font-medium text-lg">
                    <p class=" mb-2">Potrai consultare il tuo piano nel tuo account. </p>
                    <p class=" mb-2">Seguendo il regime dietetico che troverai nel tuo account, dovresti perdere almeno 6 chili in tre mesi.</p>
                    <p class=" mb-2">Puntiamo a questo risultato per tre motivi: </p>
                    <p class=" mb-2 text-blue-600">1) Tutti gli studi hanno dimostrato grandi benefici anche con riduzioni di peso del 5%.</p>
                    <p class=" mb-2 text-blue-600">2) Le perdite di peso più lente sono quelle più durature nel tempo.</p>
                    <p class=" mb-2 text-blue-600">3) Una riduzione calorica eccessiva può essere difficile da seguire.</p>
                    <p class=" mb-2 ">Preferiamo procedere per gradi, così dopo aver raggiunto il primo obiettivo a tre mesi, possiamo continuare con un obiettivo più ambizioso.</p>

                </div>

                <a href="{{route('dashboard')}}"  class=" relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                            <span class=" flex gap-2 items-center relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                Compila il questionario
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                </svg>
                            </span>
                </a>
            @endif
    </div>
    @else
        <div class="font-medium text-lg">
            <p class=" mb-2">Potrai consultare il tuo piano nel tuo account. </p>
            <p class=" mb-2">Seguendo il regime dietetico che troverai nel tuo account, dovresti perdere almeno 6 chili in tre mesi.</p>
            <p class=" mb-2">Puntiamo a questo risultato per tre motivi: </p>
            <p class=" mb-2 text-blue-600">1) Tutti gli studi hanno dimostrato grandi benefici anche con riduzioni di peso del 5%.</p>
            <p class=" mb-2 text-blue-600">2) Le perdite di peso più lente sono quelle più durature nel tempo.</p>
            <p class=" mb-2 text-blue-600">3) Una riduzione calorica eccessiva può essere difficile da seguire.</p>
            <p class=" mb-2 ">Preferiamo procedere per gradi, così dopo aver raggiunto il primo obiettivo a tre mesi, possiamo continuare con un obiettivo più ambizioso.</p>

        </div>

        <a href="{{route('dashboard')}}"  class=" mt-8 relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-lg font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                            <span class=" flex gap-2 items-center relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                Dashboard
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                </svg>
                            </span>
        </a>
   @endif

</div>
