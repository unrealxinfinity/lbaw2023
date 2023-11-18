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

    public function edit(User $user, Task $task): bool
    {
        $type = $user->persistentUser->type;
        $is_admin = $type === 'Administrator';
        $is_disabled = $type === 'Blocked' || $type === 'Deleted';
        $is_leader = $type === 'Member' && $user->persistentUser->member->projects->where('id', $task->project_id)->first()->pivot->permission_level === 'Project Leader';
        return $is_admin || (!$is_disabled && $is_leader);
        //return ($user->persistentUser->member->projects->where('id', $task->project_id)->first()->pivot->permission_level) == 'Project Leader';
    }

    public function create(User $user): bool
    {
        return ($user->persistentUser->type_ != 'Blocked') && ($user->persistentUser->type_ != 'Deleted');
    }

    public function assignMember(User $user, Task $task): bool
    {
        $type = $user->persistentUser->type;
        $is_admin = $type === 'Administrator';
        $is_disabled = $type === 'Blocked' || $type === 'Deleted';
        $project_permission = ($type === 'Member') ? $user->persistentUser->member->projects->where('id', $task->project_id)->first()->pivot->permission_level : 'None';
        return $is_admin || (!is_disabled && ($project_permission === 'Project Leader' || $project_permission === 'Member'));
        //return ($user->persistentUser->member->projects->where('id', $task->project_id)->first()->pivot->permission_level) == 'Project Leader' || ($user->persistentUser->member->projects->where('id', $task->project_id)[0]->pivot->permission_level) == 'Member' ;
    }
}

