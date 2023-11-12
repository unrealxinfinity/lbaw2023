<?php

namespace App\Policies;

use App\Models\User;
use App\Models\World;

class WorldPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function show(User $user, World $world): bool
    {
        return $user->persistentUser->type_ !== "Blocked" && $user->persistentUser->type_ !== 'Deleted';
    }
}
