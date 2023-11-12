<?php

namespace App\Policies;

use App\Models\Member;
use App\Models\User;

class MemberPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function edit(User $user, Member $member): bool
    {
        return ($user->persistentUser->type_ === 'Administrator') || ($member->user->id === $user->id);
    }

    public function create(User $user, Member $member): bool
    {
        return $user->persistentUser->type_ === 'Administrator';
    }
}
