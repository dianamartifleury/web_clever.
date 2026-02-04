<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

$secret = env('HIDDEN_LOGIN_PATH', 'hidden-login-DEFAULT'); 

/*
|--------------------------------------------------------------------------
| Bloquear rutas públicas estándar
|--------------------------------------------------------------------------
*/
Route::get('/login', fn() => abort(404));
Route::post('/login', fn() => abort(404));
Route::get('/forgot-password', fn() => abort(404));
Route::post('/forgot-password', fn() => abort(404));

/*
|--------------------------------------------------------------------------
| Rutas de login, forgot y reset password bajo la ruta secreta
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () use ($secret) {
    // Login formulario
    Route::get("/{$secret}", [AuthenticatedSessionController::class, 'create'])
        ->name('login.hidden');

    // Login submit con throttle
    Route::post("/{$secret}", [AuthenticatedSessionController::class, 'store'])
        ->name('login.hidden.submit')
        ->middleware('throttle:5,1');

    // Forgot password formulario
    Route::get("/{$secret}/forgot-password", [PasswordResetLinkController::class, 'create'])
        ->name('password.request.hidden');

    // Enviar email con token (throttle)
    Route::post("/{$secret}/forgot-password", [PasswordResetLinkController::class, 'store'])
        ->name('password.email.hidden')
        ->middleware('throttle:5,1');

    // Reset password formulario
    Route::get("/{$secret}/reset-password/{token}", [NewPasswordController::class, 'create'])
        ->name('password.reset.hidden');

    // Guardar nueva contraseña
    Route::post("/{$secret}/reset-password", [NewPasswordController::class, 'store'])
        ->name('password.update.hidden');
});

/*
|--------------------------------------------------------------------------
| Rutas protegidas (auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])
        ->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

/*
|--------------------------------------------------------------------------
| Logout disponible de forma general
|--------------------------------------------------------------------------
*/
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout')
    ->middleware('auth');
