<?php

namespace App\Policies;
use App\Models\User;
use App\Models\Project;
use App\Models\UserType;
use App\Models\World;
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
        $is_disabled = $type === UserType::Deleted->value || $type === UserType::Blocked->value;
        $is_member = $type === UserType::Member->value && $user->persistentUser->member->projects->contains('id', $project->id);
        return (!$is_disabled && $is_member);
    }
    
    
   
}
