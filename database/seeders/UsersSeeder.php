<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = UserRole::all();

        foreach ($roles as $role)
        {
            User::query()->createOrFirst([
                'user_role_id'  => $role->id,
                'name'          => strtoupper($role->name.' account'),
                'email'         => $role->name.'@dentalease.com',
                'password'      => Hash::make('password')
            ]);
        }
    }
}
