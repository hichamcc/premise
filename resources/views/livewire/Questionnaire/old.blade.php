<div class="">
    <div class="mt-4 overflow-hidden rounded-full bg-gray-200">
        <div class="h-2 rounded-full bg-blue-700" style="width: {{ ($currentQuestionIndex + 1) / $totalQuestions * 100 }}%"></div>
    </div>

    <div class="mt-4 min-h-[600px] text-center">
        @if ($currentQuestion)
            <p class="text-4xl font-medium text-blue-700 text-center mt-8">{{ $currentQuestion['label'] }}</p>
        @endif
        @if ($currentQuestion)
            <div class="min-h-[500px] content-center">
                @if ($currentQuestion['type'] === 'select')
                    <ul class="grid w-full gap-6 md:grid-cols-2">
                        @foreach ($currentQuestion['options'] as $option)
                            <li>
                                <input wire:model="answers.{{ $questionKeys[$currentQuestionIndex] }}" type="radio" id="{{ preg_replace('/\s+/', '', $option) }}" name="{{ $questionKeys[$currentQuestionIndex] }}" value="{{ $option }}" class="hidden peer" required />
                                <label for="{{ preg_replace('/\s+/', '', $option) }}" class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border-2 border-gray-200 rounded-2xl cursor-pointer peer-checked:border-blue-600 peer-checked:text-white peer-checked:bg-gradient-to-r peer-checked:from-blue-700 peer-checked:to-blue-400 hover:text-gray-600 hover:bg-gray-100">
                                    <div class="block">
                                        <div class="w-full text-lg font-semibold">{{ $option }}</div>
                                    </div>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                @elseif ($currentQuestion['type'] === 'checkbox')
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
                @elseif ($currentQuestion['type'] === 'text')
                    <input type="text" wire:model="answers.{{ $questionKeys[$currentQuestionIndex] }}" name="{{ $questionKeys[$currentQuestionIndex] }}" id="{{ $questionKeys[$currentQuestionIndex] }}" class="mt-2 block w-1/2 mx-auto h-[100px] text-xl px-4 py-2 rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0" placeholder="{{ $currentQuestion['placeholder'] ?? 'Enter your answer' }}">
                @elseif ($currentQuestion['type'] === 'file')
                    <input type="file" wire:model="answers.{{ $questionKeys[$currentQuestionIndex] }}" name="{{ $questionKeys[$currentQuestionIndex] }}" id="{{ $questionKeys[$currentQuestionIndex] }}" class="mt-2 block w-1/2 px-4 py-2 rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0">
                @endif
            </div>
            <button wire:click="nextQuestion" class="bottom-0 relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-blue-700 to-blue-400 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                <span class="flex gap-2 items-center relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                    Next Step
                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                    </svg>
                </span>
            </button>
        @else
            <p>You have completed the questionnaire.</p>
        @endif
    </div>
</div>
