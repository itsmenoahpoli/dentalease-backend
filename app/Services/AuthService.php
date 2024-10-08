<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use App\Services\UsersService;
use App\Models\UserCode;
use App\Mail\UserCode as UserCodeMail;
use App\Traits\NotificationTraits;

class AuthService
{
    use NotificationTraits;

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
            $notificationType = 'sms';
            $user = $this->usersService->getByEmail($payload['email']);
            $code = UserCode::query()->create([
                'user_id'   => $user->id,
                'code'      => strtoupper(Str::random(8))
            ]);

            if ($notificationType === 'sms')
            {
                return $this->sendSms('639620636535', 'Your verification code is '.$code->code);
            } else
            {
                Mail::to($user->email)->send(new UserCodeMail($code->code));
            }

            return 'Code created & send via e-mail';
        } catch (\Exception $error)
        {
            return 'Failed to send mail to user';
        }
    }

    public function verifyCode($payload)
    {
        $user = $this->usersService->getByEmail($payload['email']);
        $code = UserCode::query()->where('code', $payload['code'])->firstOrFail();

        if ($user && $code && $code->expires_at <= now())
        {
            return 'Code verified';
        }

        return 'Code may be invalid/used/expired';
    }
}
