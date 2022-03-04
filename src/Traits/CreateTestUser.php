<?php

declare(strict_types=1);

namespace Zekini\Generics\Traits;

use App\Models\User;

trait CreateTestUser
{
    public function createUser(?array $array = []): User
    {
        $user = User::factory()->create($array);

        return User::findOrFail($user->id);
    }

    public function createAdminUser(?array $array = []): User
    {
        $user = User::factory()->create($array);
        $user->assignRole('super-admin');

        return User::findOrFail($user->id);
    }
}
