<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UsersRepository extends BaseRepository
{
    public function __construct(readonly Model $model, array $relationships, array $relationshipsInList)
    {
        parent::__construct($model, $relationships, $relationshipsInList);
    }

    public function create($payload)
    {
        $payload['code'] = Str::random(8);

        return parent::create($payload);
    }

    public function getByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }
}
