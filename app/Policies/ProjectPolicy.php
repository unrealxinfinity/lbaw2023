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
        $type = $user->persistentUser->type_;
        $is_admin = $type === 'Administrator';
        $is_disabled = $type === 'Blocked' || $type === 'Deleted';
        return $is_admin || !$is_disabled;
    }

    public function addMember(User $user, Project $project): bool
    {
        $type = $user->persistentUser->type_;
        $is_admin = $type === 'Administrator';
        $is_disabled = $type === 'Blocked' || $type === 'Deleted';
        $is_world_admin = $type === 'Member' && $user->persistentUser->member->worlds->contains('id', $project->world_id) &&$user->persistentUser->member->worlds->where('id', $project->world_id)->first()->pivot->is_admin;
        $is_leader = $type === 'Member' && $user->persistentUser->member->projects->contains('id', $project->id) && $user->persistentUser->member->projects->where('id', $project->id)->first()->pivot->permission_level === 'Project Leader';
        return $is_admin || (!$is_disabled && ($is_leader || $is_world_admin));
    }

    public function edit(User $user, Project $project): bool
    {
        $type = $user->persistentUser->type_;
        $is_admin = $type === 'Administrator';
        $is_disabled = $type === 'Blocked' || $type === 'Deleted';
        $is_world_admin = $type === 'Member' && $user->persistentUser->member->worlds->contains('id', $project->world_id) &&$user->persistentUser->member->worlds->where('id', $project->world_id)->first()->pivot->is_admin;
        $is_leader = $type === 'Member' && $user->persistentUser->member->projects->contains('id', $project->id) && $user->persistentUser->member->projects->where('id', $project->id)->first()->pivot->permission_level === 'Project Leader';
        return $is_admin || (!$is_disabled && ($is_leader || $is_world_admin));
    }

    public function leave(User $user, Project $project): bool
    {
        $type = $user->persistentUser->type_;
        $is_member = $type === 'Member' && $user->persistentUser->member->projects->contains('id', $project->id);
        return $is_member;
    }

    public function delete(User $user, Project $project): bool
    {
        $type = $user->persistentUser->type_;
        $is_admin = $type === 'Administrator';
        $is_disabled = $type === 'Blocked' || $type === 'Deleted';
        $is_world_admin = $type === 'Member' && $user->persistentUser->member->worlds->contains('id', $project->world_id) && $user->persistentUser->member->worlds->where('id', $project->world_id)->first()->pivot->is_admin;
        $is_leader = $type === 'Member' && $user->persistentUser->member->projects->contains('id', $project->id) && $user->persistentUser->member->projects->where('id', $project->id)->first()->pivot->permission_level === 'Project Leader';
        return $is_admin || (!$is_disabled && ($is_leader || $is_world_admin));
    }

    public function create(User $user): bool
    {
        $request = request()->input();
        $type = $user->persistentUser->type_;
        $is_disabled = $type === 'Blocked' || $type === 'Deleted';
        $world = World::find($request['world_id']);
        $is_world_admin = $user->persistentUser->member->worlds->where('id', $world->id)->first()->pivot->is_admin;
        return !$is_disabled && $is_world_admin;
    }

    public function projectTagCreate(User $user,Project $project): bool
    {   
        return ($user->persistentUser->type_ != 'Blocked') && ($user->persistentUser->type_ != 'Deleted') ;
    }
    public function searchTask(User $user): bool
    {   
        return ($user->persistentUser->type_ != 'Blocked') && ($user->persistentUser->type_ != 'Deleted');
    }
}