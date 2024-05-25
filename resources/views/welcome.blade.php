<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    <style>
        @keyframes slideInLeft {
            from {
                transform: translateX(-100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Apply left-to-right animation to fade-in class */
        .slide-in-left {
            animation: slideInLeft 1.5s ease-in-out;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-image: url({{asset("images/background.jpg")}});
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            box-shadow: 0 8px 32px 0 rgba( 31, 38, 135, 0.37 );
            backdrop-filter: blur( 5.5px );
            -webkit-backdrop-filter: blur( 5.5px );
            border-radius: 10px;

        }

        body::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba( 46, 45, 45, 0.5 );
            z-index: 0;
        }
        main {
            flex: 1;
            z-index: 99;
        }
        .text-light {
            color: #54a1a8;
        }
        .text-default {
            color: #4f96a7;
        }
        .text-dark {
            color: #2c5965;
        }
        .bg-dark {
            background: #2c5965;
        }


    </style>
</head>

<body>
<header class="bg-white shadow-md z-10">
    <div class="container mx-auto px-6 py-3 flex justify-between items-center">
        <img src="{{asset('images/logo.png')}}" class="w-16" alt="">
        <div>
            @auth
                <a href="{{ url('/dashboard') }}" class="text-gray-800 hover:text-light text-white py-2 px-8  rounded-2xl bg-dark">Dashboard</a>

            @else
            <a href="{{ route('register') }}" class="text-dark font-semibold hover:text-gray-600 mx-4">Sign Up</a>
            <a href="{{ route('login') }}" class="text-gray-800 hover:text-light text-white py-2 px-8  rounded-2xl bg-dark">Sign In</a>
            @endauth

        </div>
    </div>
</header>

<main class="container mx-auto px-6 py-16 flex items-center justify-between slide-in-left">
    <div class="w-full text-center">
        <h1 class="sm:text-7xl text-4xl font-bold text-white">Generate Custom Diets Easily With</h1>
        <h1>
            <img src="{{asset('images/logo.png')}}" class="sm:w-24 w-48 m-auto p-4 bg-white rounded-2xl shadow-xl mt-4" alt="">
        </h1>


        <section class="m-16">
            <a href="{{ route('register') }}" class="text-white font-bold sm:text-2xl text-xl  bg-dark p-4 rounded-2xl mt-4 hover:bg-gray-700  ">Let's get started</a>
        </section>


        <p class="mt-4  sm:text-2xl text-xl text-white">Obesity profoundly affects the state of health since it is accompanied by important diseases such as type 2 diabetes mellitus, arterial
            hypertension, ischemic heart disease and other morbid conditions which, to varying degrees, worsen the quality of life and shorten its duration.</p>

    </div>

</main>


<!-- Footer -->
<footer class="bg-dark z-10">
    <div class="container mx-auto px-6 py-4 text-center text-white">
        &copy; 2024 FITFORMA. All rights reserved.
    </div>
</footer>


</body>

</html>
