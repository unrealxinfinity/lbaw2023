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
        $type = $user->persistentUser->type;
        $is_admin = $type === 'Administrator';
        $is_disabled = $type === 'Blocked' || $type === 'Deleted';
        $is_in_world = $type === 'Member' && $user->persistentUser->member->worlds->contains($project->world_id);
        return $is_admin || (!$is_disabled && $is_in_world);
        //return $user->persistentUser->type_ === 'Administrator' || ($user->persistentUser->type_ === 'Member' && $user->persistentUser->member->worlds->contains($project->world_id));
    }

    public function addMember(User $user, Project $project): bool
    {
        $type = $user->persistentUser->type;
        $is_admin = $type === 'Administrator';
        $is_disabled = $type === 'Blocked' || $type === 'Deleted';
        $is_leader = $type === 'Member' || $user->persistentUser->member->projects->where('id', $project->id)->first()->pivot->permission_level === 'Project Leader';
        return $is_admin || (!$is_disabled && $is_leader);
        //return ($user->persistentUser->member->projects->where('id', $project->id)->first()->pivot->permission_level) == 'Project Leader';
    }

    public function delete(User $user, Project $project): bool
    {
        $type = $user->persistentUser->type;
        $is_admin = $type === 'Administrator';
        $is_disabled = $type === 'Blocked' || $type === 'Deleted';
        $is_leader = $type === 'Member' || $user->persistentUser->member->projects->where('id', $project->id)->first()->pivot->permission_level === 'Project Leader';
        return $is_admin || (!$is_disabled && $is_leader);
        //return ($user->persistentUser->type_ == 'Administrator') || (($user->persistentUser->member->projects->where('id', $project->id)->first()->pivot->permission_level) == 'Project Leader');
    }

    public function create(User $user): bool
    {
        $type = $user->persistentUser->type;
        $is_disabled = $type === 'Blocked' || $type === 'Deleted';
        return !$is_disabled;
        //return ($user->persistentUser->type_ != 'Blocked') && ($user->persistentUser->type_ != 'Deleted');
    }
}