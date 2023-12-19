<?php

namespace App\Policies;

use App\Models\WorldComment;
use App\Models\User;
use App\Models\UserType;

class WorldCommentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function edit(User $user, WorldComment $comment): bool
    {
        $is_disabled = $user->persistentUser->type_ == UserType::Deleted->value || $user->persistentUser->type_ == UserType::Blocked->value;
        $is_owner = $comment->member->user_id == $user->id;
        return !$is_disabled && $is_owner;
    }
}
