<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;
use App\Models\World;

class ProjectPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    

    public function show(User $user, Project $project): bool
    {
        $userId = $user->persistentUser->id;
        $isMember = false;
        $world = World::find($project->world_id);
        foreach ($world->members as $member) {
            if ($member->id == $userId) {
                $isMember = true;
                break;
            }
        }
        return $user->persistentUser->type_ !== "Blocked" && $user->persistentUser->type_ !== 'Deleted' && $isMember;
    }

    public function addMember(User $user, Project $project): bool
    {
        return ($user->persistentUser->member->projects->where('id', $project->id)[0]->pivot->permission_level) == 'Project Leader';
    }

    public function create(User $user): bool
    {
        return ($user->persistentUser->type_ != 'Blocked') && ($user->persistentUser->type_ != 'Deleted');
    }
}