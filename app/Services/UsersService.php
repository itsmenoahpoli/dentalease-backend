<?php

namespace App\Services;

use App\Repositories\UsersRepository;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UsersService extends UsersRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model, [], []);
    }

    public function getByEmail($email)
    {
        $user = parent::getByEmail($email);

        if (!$user)
        {
            throw new NotFoundHttpException('User not found');
        }

        return $user;
    }
}
