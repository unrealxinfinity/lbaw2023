<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Tag;

class TagPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        
    }
    public function create(User $user,Tag $tag): bool
    {
        return ($user->persistentUser->type_ != 'Blocked') && ($user->persistentUser->type_ != 'Deleted') &&($tag->name != '');
    }
}
