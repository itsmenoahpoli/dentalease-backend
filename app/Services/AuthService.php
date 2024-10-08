<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthService
{
    public function authenticate($credentials): array
    {
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            /**
             * @var \App\Models\User::class $user
             */
            $token = $user->createToken(
                time(), [$user->role], now()->addHours(24)
            )->plainTextToken;

            return [
                'user' => $user,
                'token' => $token
            ];
        }

        throw new UnauthorizedHttpException('Bearer', 'Invalid credentials provided');
    }
}
