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
        return ($user->persistentUser->member->projects->where('id', $task->project_id)[0]->pivot->permission_level) == 'Project Leader';
    }

    public function create(User $user): bool
    {
        return ($user->persistentUser->type_ != 'Blocked') && ($user->persistentUser->type_ != 'Deleted');
    }

    public function assignMember(User $user, Task $task): bool
    {
        return ($user->persistentUser->member->projects->where('id', $task->project_id)[0]->pivot->permission_level) == 'Project Leader' || ($user->persistentUser->member->projects->where('id', $task->project_id)[0]->pivot->permission_level) == 'Member' ;
    }
}

