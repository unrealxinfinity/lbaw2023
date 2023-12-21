<?php

namespace App\Policies;

use App\Models\ProjectPermission;
use App\Models\User;
use App\Models\Task;
use App\Models\UserType;

class TaskPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function show(?User $user, Task $task): bool
    {
        if ($user == null) return false;
        $type = $user->persistentUser->type_;
        $is_admin = $type === UserType::Administrator->value;
        $is_disabled = $type === UserType::Blocked->value || $type === UserType::Deleted->value;
        return $is_admin || !$is_disabled;
    }

    public function edit(User $user, Task $task): bool
    {
        $type = $user->persistentUser->type_;
        $is_admin = $type === UserType::Administrator->value;
        $is_disabled = $type === UserType::Blocked->value || $type === UserType::Deleted->value;
        if($is_admin || $is_disabled) return false;
        $is_project_member = $user->persistentUser->member->projects->contains($task->project_id);
        return $is_admin || (!$is_disabled && $is_project_member);
    }

    public function delete(?User $user, Task $task): bool
    {
        if($user == null) return false;
        $type = $user->persistentUser->type_;
        $is_admin = $type === UserType::Administrator->value;
        $is_disabled = $type === UserType::Blocked->value || $type === UserType::Deleted->value;
        if($is_admin) return true;
        $is_project_member = $user->persistentUser->member->projects->contains($task->project_id);
        return !$is_disabled && $is_project_member;
    }

    public function create(User $user): bool
    {
        return ($user->persistentUser->type_ != UserType::Blocked->value) && ($user->persistentUser->type_ != UserType::Deleted->value);
    }

    public function assignMember(User $user, Task $task): bool
    {
        $type = $user->persistentUser->type_;
        $is_admin = $type === UserType::Administrator->value;
        $is_disabled = $type === UserType::Blocked->value || $type === UserType::Deleted->value;
        $project_permission = ($type === UserType::Member->value) ? $user->persistentUser->member->projects->where('id', $task->project_id)->first()->pivot->permission_level : 'None';
        return $is_admin || (!$is_disabled && ($project_permission === ProjectPermission::Leader->value || $project_permission === ProjectPermission::Member->value));
    }
}

