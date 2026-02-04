<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Editar Perfil</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" href="{{ asset('assets/img/favicon.png') }}" type="image/png">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!--Style -->
        <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    </head>
    <body class="page-wrapper">
        <div class="guest-container">
            <div class="logo-container">
                <a href="/">
                    <x-application-logo class="logo-img" />
                </a>
            </div>

            <div class="guest-content">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
