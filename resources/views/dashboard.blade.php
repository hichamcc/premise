<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center min-h-[500px]">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold mb-4 text-4xl text-center text-blue-700 leading-tight">
                        {{ __('Welcome To PREMISE ') }}
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
                    @else

                     <div class="flex flex-1 justify-center mt-8 gap-8 m-auto">
                         <a href="{{route('diets')}}" class="text-center block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                             <img class="w-[120px] h-auto m-auto" src="{{asset('images/diet.png')}}" alt="">
                             <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white mt-4">Check your diet plan</h5>
                         </a>
                         <a href="{{route('workouts')}}" class="text-center block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

                             <img class="w-[120px] h-auto m-auto" src="{{asset('images/workout.png')}}" alt="">

                             <h5 class="mb-2 text-2xl font-semibold tracking-tight text-gray-900 dark:text-white mt-4">Check your workout</h5>
                         </a>
                     </div>

                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
