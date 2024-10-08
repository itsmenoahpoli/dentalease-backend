<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserRole;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['admin'];

        foreach ($roles as $role)
        {
            UserRole::query()->createOrFirst([
                'name'          => $role,
                'is_enabled'    => true
            ]);
        }
    }
}
