<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Task;

class TaskPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function show(User $user, Task $task): bool
    {
        $type = $user->persistentUser->type_;
        $is_admin = $type === 'Administrator';
        $is_disabled = $type === 'Blocked' || $type === 'Deleted';
        return $is_admin || !$is_disabled;
    }

    public function edit(User $user, Task $task): bool
    {
        $type = $user->persistentUser->type_;
        $is_admin = $type === 'Administrator';
        $is_disabled = $type === 'Blocked' || $type === 'Deleted';
        $is_project_member = $user->persistentUser->member->projects->contains('id', $task->project_id);
        return $is_admin || (!$is_disabled && $is_project_member);
    }

    public function create(User $user): bool
    {
        return ($user->persistentUser->type_ != 'Blocked') && ($user->persistentUser->type_ != 'Deleted');
    }

    public function assignMember(User $user, Task $task): bool
    {
        $type = $user->persistentUser->type_;
        $is_admin = $type === 'Administrator';
        $is_disabled = $type === 'Blocked' || $type === 'Deleted';
        $project_permission = ($type === 'Member') ? $user->persistentUser->member->projects->where('id', $task->project_id)->first()->pivot->permission_level : 'None';
        return $is_admin || (!$is_disabled && ($project_permission === 'Project Leader' || $project_permission === 'Member'));
    }
}

