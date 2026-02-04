<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/img/favicon.png') }}" type="image/png">

    <!-- CSS principal -->
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
</head>

<body>
    <div class="page-wrapper">
        <div class="page-container">
            <div class="content-box login-box">
                
                <!-- Logo -->
                <div class="logo-container" style="text-align: center; margin-bottom: 1.5rem;">
                    <img src="{{ asset('assets/img/logoclevertrading-web.png') }}" 
                         alt="Logo" 
                         style="max-width: 150px; height: auto;">
                </div>

                <!-- Título -->
                <h2 style="text-align: center; margin-bottom: 1rem;">Bienvenido a CleverTrading</h2>

                <!-- Formulario de Login -->
                <form method="POST" action="{{ route('login.hidden.submit') }}">
                    @csrf

                    <!-- Email -->
                    <div style="text-align: center;">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input id="email" 
                               class="form-input" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus 
                               autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div style="text-align: center; margin-top: 1rem;">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" 
                               class="form-input" 
                               type="password" 
                               name="password" 
                               required 
                               autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Recordarme -->
                    <div class="block mt-4" style="text-align: center;">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300">
                            <span class="ms-2 text-sm text-gray-700">{{ __('Recordarme') }}</span>
                        </label>
                    </div>

                    <!-- Botones -->
                    <div class="button-container" style="justify-content: center; margin-top: 1.5rem;">
                        @if (Route::has('password.request.hidden'))
                            <a href="{{ route('password.request.hidden') }}" class="btn btn-secondary">
                                {{ __('¿Olvidaste tu contraseña?') }}
                            </a>
                        @endif

                        <button type="submit" class="btn">
                            {{ __('Iniciar sesión') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>
</html>
