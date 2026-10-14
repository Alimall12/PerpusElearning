<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Firebase SDK -->
        <script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-app-compat.js"></script>
        <script src="https://www.gstatic.com/firebasejs/10.7.1/firebase-auth-compat.js"></script>
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-[#081C15] antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#EBF2FA]">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-[#1B4322]" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg border border-[#038666]">
                {{ $slot }}
            </div>
        </div>
        
        <!-- Firebase Config -->
        <script>
            // TODO: Ganti dengan config dari Firebase Console
            const firebaseConfig = {
                apiKey: "AIzaSyAudPJIOzjk1Ax8BqItKkVD0wC7gpROWdo",
                authDomain: "myownproject-dbc85.firebaseapp.com",
                projectId: "myownproject-dbc85",
                storageBucket: "myownproject-dbc85.firebasestorage.app",
                messagingSenderId: "17538723534",
                appId: "1:17538723534:web:692d4ab5dded0ee7372a9f",
                measurementId: "G-BW3VLZNZQR"
            };
            
            firebase.initializeApp(firebaseConfig);
        </script>
    </body>
</html>
