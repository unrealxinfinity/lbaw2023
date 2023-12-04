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
        $type = $user->persistentUser->type_;
        $is_disabled = $type === 'Blocked' || $type === 'Deleted';
        $is_member = $type === 'Member' && $user->persistentUser->member->projects->contains('id', $project->id);
        return (!$is_disabled && $is_member);
    }
    
}
