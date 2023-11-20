<?php

namespace App\Policies;
use App\Models\User;
use App\Models\Project;

class TagPolicy
{   
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        
    }
    public function projectTagCreate(User $user,Project $project): bool
    {   
        return ($user->persistentUser->type_ != 'Blocked') && ($user->persistentUser->type_ != 'Deleted') ;
    }
    
}
