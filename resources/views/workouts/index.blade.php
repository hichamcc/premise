<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center min-h-[500px]">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold mb-4 text-2xl text-center text-blue-700 leading-tight">
                        {{ __('Workout of the Day') }}
                    </h2>

                    @if (!$hasAnsweredQuestionnaire)
                        <div class="min-h-[300px] content-center">
                            <p class="font-semibold text-center text-4xl">You haven't taken the questionnaire yet. Please take the questionnaire to generate a custom diet.</p>
                        </div>
                        <a href="{{route('questionnaire')}}"  class=" relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                            <span class=" flex gap-2 items-center relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                Take Questionnaire
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                </svg>
                            </span>
                        </a>
                    @endif

                    <div class="p-4">
                        @if ($workoutVideo)
                            <div class="aspect-w-16 aspect-h-9">
                                <video controls class="w-full rounded-lg">
                                    <source src="storage/{{ $workoutVideo }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        @else
                            <p class="text-gray-600">No workout video available for today.</p>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
