<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;
use App\Models\ProjectPermission;
use App\Models\UserType;
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
        $is_admin = $type === UserType::Administrator->value;
        $is_disabled = $type === UserType::Blocked->value || $type === UserType::Deleted->value;
        return $is_admin || !$is_disabled;
    }

    public function addMember(User $user, Project $project): bool
    {
        $type = $user->persistentUser->type_;
        $is_admin = $type === UserType::Administrator->value;
        $is_disabled = $type === UserType::Blocked->value || $type === UserType::Deleted->value;
        $is_world_admin = $type === UserType::Member->value && $user->persistentUser->member->worlds->contains('id', $project->world_id) &&$user->persistentUser->member->worlds->where('id', $project->world_id)->first()->pivot->is_admin;
        $is_leader = $type === UserType::Member->value && $user->persistentUser->member->projects->contains('id', $project->id) && $user->persistentUser->member->projects->where('id', $project->id)->first()->pivot->permission_level === ProjectPermission::Leader->value;
        $is_active = $project->status != 'Archived';
        return ((!$is_admin && !$is_disabled && ($is_leader || $is_world_admin))) && $is_active;
    }

    
    public function removeMember(User $user, Project $project): bool
    {
        $type = $user->persistentUser->type_;
        $is_disabled = $type === UserType::Blocked->value || $type === UserType::Deleted->value;
        $is_world_admin = $type === UserType::Member->value && $user->persistentUser->member->worlds->contains('id', $project->world_id) &&$user->persistentUser->member->worlds->where('id', $project->world_id)->first()->pivot->is_admin;
        $is_leader = $type === UserType::Member->value && $user->persistentUser->member->projects->contains('id', $project->id) && $user->persistentUser->member->projects->where('id', $project->id)->first()->pivot->permission_level === ProjectPermission::Leader->value;
        return (!$is_disabled && $is_leader);
    }
    public function AssignProjectLeader(User $user , Project $project): bool
    {
        $type = $user->persistentUser->type_;
        $is_disabled = $type === UserType::Blocked->value || $type === UserType::Deleted->value;
        $is_world_admin = $type === UserType::Member->value && $user->persistentUser->member->worlds->contains('id', $project->world_id) &&$user->persistentUser->member->worlds->where('id', $project->world_id)->first()->pivot->is_admin;
        $is_leader = $type === UserType::Member->value && $user->persistentUser->member->projects->contains('id', $project->id) && $user->persistentUser->member->projects->where('id', $project->id)->first()->pivot->permission_level === ProjectPermission::Leader->value;
        return ((!$is_disabled && $is_leader) || (!$is_disabled && $is_world_admin));
    }
    public function removeLeader(User $user, Project $project): bool
    {
        $type = $user->persistentUser->type_;
        $is_disabled = $type === UserType::Blocked->value || $type === UserType::Deleted->value;
        $is_world_admin = $type === UserType::Member->value && $user->persistentUser->member->worlds->contains('id', $project->world_id) &&$user->persistentUser->member->worlds->where('id', $project->world_id)->first()->pivot->is_admin;
        return (!$is_disabled && $is_world_admin);
    }

    public function leave(User $user, Project $project): bool
    {
        $type = $user->persistentUser->type_;
        $is_member = $type === UserType::Member->value && $user->persistentUser->member->projects->contains('id', $project->id);
        return $is_member;
    }

    public function delete(User $user, Project $project): bool
    {
        $type = $user->persistentUser->type_;
        $is_admin = $type === UserType::Administrator->value;
        $is_disabled = $type === UserType::Blocked->value || $type === UserType::Deleted->value;
        $is_world_admin = $type === UserType::Member->value && $user->persistentUser->member->worlds->contains('id', $project->world_id) && $user->persistentUser->member->worlds->where('id', $project->world_id)->first()->pivot->is_admin;
        $is_leader = $type === UserType::Member->value && $user->persistentUser->member->projects->contains('id', $project->id) && $user->persistentUser->member->projects->where('id', $project->id)->first()->pivot->permission_level === ProjectPermission::Leader->value;
        return $is_admin || (!$is_disabled && ($is_leader || $is_world_admin));
    }

    public function create(User $user): bool
    {
        $request = request()->input();
        $type = $user->persistentUser->type_;
        $is_disabled = $type === UserType::Blocked->value || $type === UserType::Deleted->value;
        $world = World::find($request['world_id']);
        $is_world_admin = $user->persistentUser->member->worlds->where('id', $world->id)->first()->pivot->is_admin;
        return !$is_disabled && $is_world_admin;
    }

    public function edit(User $user, Project $project): bool
    {
        $type = $user->persistentUser->type_;
        $is_admin = $type === UserType::Administrator->value;
        $is_disabled = $type === UserType::Blocked->value || $type === UserType::Deleted->value;
        $is_leader = $type === UserType::Member->value && $user->persistentUser->member->projects->contains('id', $project->id) && $user->persistentUser->member->projects->where('id', $project->id)->first()->pivot->permission_level === ProjectPermission::Leader->value;
        return (!$is_admin && !$is_disabled && $is_leader);
    }

    public function createTask(User $user, Project $project): bool
    {
        $type = $user->persistentUser->type_;
        $is_admin = $type === UserType::Administrator->value;
        $is_disabled = $type === UserType::Blocked->value || $type === UserType::Deleted->value;
        $is_member = $type === UserType::Member->value && $user->persistentUser->member->projects->contains('id', $project->id);
        $is_active = $project->status != 'Archived';
        return ((!$is_admin && !$is_disabled && $is_member)) && $is_active;
    }

    public function projectTagCreate(User $user,Project $project): bool
    {   
        $type = $user->persistentUser->type_;
        $is_disabled = $type === UserType::Blocked->value || $type === UserType::Deleted->value;
        $is_member = $type === UserType::Member->value && $user->persistentUser->member->projects->contains('id', $project->id);
        return (!$is_disabled && $is_member);
    }
    public function deleteProjectTag(User $user,Project $project): bool
    {   
        $type = $user->persistentUser->type_;
        $is_disabled = $type === UserType::Blocked->value || $type === UserType::Deleted->value;
        $is_member = $type === UserType::Member->value && $user->persistentUser->member->projects->contains('id', $project->id);
        return (!$is_disabled && $is_member);
    }
    public function searchTask(User $user): bool
    {   
        $type = $user->persistentUser->type_;
        $is_disabled = $type === UserType::Blocked->value || $type === UserType::Deleted->value;
        return !$is_disabled;
    }

    public function favorite(User $user, Project $project): bool
    {
        return ($user->persistentUser->type_ != UserType::Blocked->value) && ($user->persistentUser->type_ != UserType::Deleted->value);
    }

}   
    