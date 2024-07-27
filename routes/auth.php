<?php

use App\Http\Controllers\v1\Auth\AuthController;
use App\Http\Controllers\v1\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\v1\Auth\NewPasswordController;
use App\Http\Controllers\v1\Auth\PasswordResetLinkController;
use App\Http\Controllers\v1\Auth\RegisteredUserController;
use App\Http\Controllers\v1\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

// Route::post('/register', [RegisteredUserController::class, 'store']);


Route::controller(AuthController::class)->prefix('auth')->group(function () {

    Route::post('/register', 'register');
    Route::post('/login', 'login');

    //Auth routes that require authentication
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('/logout', 'logout');
        Route::post('/email/verification-notification','emailVerificationNotification')->middleware(['throttle:6,1']);
        // Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['signed', 'throttle:6,1']);
    });
    
});

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.store');

//Auth routes that require authentication
Route::group(['middleware' => 'auth:sanctum'], function () {
    // Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
    //     ->middleware(['auth', 'signed', 'throttle:6,1']);

    // Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    //     ->middleware(['auth', 'throttle:6,1'])
    //     ->name('verification.send');
});
