<?php

namespace App\Http\Controllers\v1\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\v1\Auth\AuthService;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\v1\Auth\LoginRequest;
use App\Http\Requests\v1\Auth\RegisterRequest;
use App\Http\Requests\v1\Auth\PasswordResetRequest;
use App\Http\Requests\v1\Auth\ForgotPasswordRequest;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        return $this->authService->registerUser($request);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return $this->authService->login($request);
    }

    public function forgot_password(ForgotPasswordRequest $request): JsonResponse
    {
        return $this->authService->forgot_password($request);
    }

    public function password_reset(PasswordResetRequest $request): JsonResponse
    {
        return $this->authService->password_reset($request);
    }

    public function emailVerificationNotification(Request $request): JsonResponse|RedirectResponse
    {
        return $this->authService->sendEmailVerificationNotification($request);
    }

    /**
     * Destroy an authenticated session.
     */
    public function logout(Request $request): Response
    {
        return $this->authService->logout($request);
    }
}
