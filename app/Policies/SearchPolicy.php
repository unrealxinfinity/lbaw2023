<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Member;

class SearchPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function showSearchResults(User $user,Member $member): bool
    {
        return true;
    }
}
