<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use App\Services\UsersService;
use App\Models\UserCode;
use App\Mail\UserCode as UserCodeMail;

class AuthService
{
    public function __construct(
        readonly UsersService $usersService
    )
    {}

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

    public function createCode($payload)
    {
        try
        {
            $user = $this->usersService->getByEmail($payload['email']);
            $code = UserCode::query()->create([
                'user_id' => $user->id,
                'code' => strtoupper(Str::random(8))
            ]);

            Mail::to($user->email)->send(new UserCodeMail($code->code));

            return 'Code created & send via e-mail';
        } catch (\Exception $error)
        {
            return 'Failed to send mail to user';
        }
    }
}
