<x-app-layout>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg  min-h-[500px]">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold mb-8 text-4xl text-center  leading-7 text-blue-700">
                        {{ __('Piano alimentare') }}
                    </h2>

                    @if (!$hasAnsweredQuestionnaire)
                        <div class="min-h-[300px] content-center">
                            <p class="font-semibold text-center text-4xl">Non hai ancora completato il questionario. Per favore, compila il questionario per generare una dieta personalizzata.</p>
                        </div>
                        <a href="{{route('questionnaire')}}"  class=" relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                            <span class=" flex gap-2 items-center relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                Compila il questionario
                                <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                </svg>
                            </span>
                        </a>

                    @else


                        <ol class="relative border-s border-gray-200 dark:border-gray-700">
                            @foreach($dietPlans as $plan)
                                <li class="mb-10 ms-6">
                                <span
                                    class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-gray-900 dark:bg-blue-900">
                                    <svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                </span>
                                    <h3 class="flex items-center mb-1 text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $plan->day->translatedFormat('l, j F Y') }}
                                   </h3>

                                    <div class="max-w-xl m-auto p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                        <div class="rich-text">{!! $plan->description !!}</div>
                                    </div>

                                </li>

                            @endforeach


                        </ol>


                    @endif



                </div>
            </div>
        </div>
    </div>
</x-app-layout>
