<?php

namespace App\Policies;

use App\Models\User;

class NotificationPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $user,string $world_id, string $project_id,string $task_id): bool
    {

        $type = $user->persistentUser->type_;
        $is_member = $type === 'Member';

        return !empty($world_id) && !empty($project_id) && !empty($task_id) && $is_member;

    }
}
