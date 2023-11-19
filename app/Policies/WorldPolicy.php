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

    public function create(User $user): bool
    {
        return $user->persistentUser->type_ !== "Blocked" && $user->persistentUser->type_ !== 'Deleted';
    }

    public function addMember(User $user, World $world): bool
    {
        return ($user->persistentUser->member->worlds->where('id', $world->id)->first()->pivot->is_admin);
    }

    public function comment(User $user, World $world): bool
    {
        return ($user->persistentUser->type_ === 'Member') && ($user->persistentUser->member->worlds->contains($world->id));
    }
}
