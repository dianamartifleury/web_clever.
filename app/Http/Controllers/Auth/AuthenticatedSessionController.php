<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validar campos
        $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        // Restringir a usuarios permitidos
        $allowed = array_filter(array_map('trim', explode(',', env('ALLOWED_LOGIN_USERS', ''))));
        if (!empty($allowed) && !in_array($request->email, $allowed, true)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // Intentar autenticar
        $credentials = $request->only('email', 'password');

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // Regenerar sesión para seguridad
        $request->session()->regenerate();

        // Redirigir al destino previsto o al home
         return redirect()->intended(config('fortify.home', '/'));
    }

    /**php
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // Volver al home
    }
}
