<?php

namespace App\Policies;

use App\Models\Member;
use App\Models\User;

class MemberPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function edit(User $user, Member $member): bool
    {
        $type = $user->persistentUser->type_;
        $is_admin = $type === 'Administrator';
        $is_disabled = $type === 'Blocked' || $type === 'Deleted';
        $is_member = $member->user->id == $user->id;
        return $is_admin || (!$is_disabled && $is_member);
        //return ($user->persistentUser->type_ === 'Administrator') || ($member->user->id === $user->id);
    }

    public function create(User $user, Member $member): bool
    {
        return $user->persistentUser->type_ === 'Administrator';
    }

    public function list(User $user): bool
    {
        return $user->persistentUser->type_ === 'Administrator';
    }
    public function showSearchResults(User $user,Member $member): bool
    {   
        
        $type = $user->persistentUser->type_; 
        $is_disabled = $type === 'Blocked' || $type === 'Deleted';
        $is_member = $member->user_id == $user->id;
        return (!$is_disabled && $is_member ) ;
    }

    public function showCreateWorld(User $user): bool
    {
        return $user->persistentUser->type_ == 'Member';
    }
}
