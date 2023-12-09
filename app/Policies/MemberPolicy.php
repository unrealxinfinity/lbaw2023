<?php

namespace App\Policies;

use App\Models\Member;
use App\Models\User;
use App\Models\Notification;

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
        return (!$is_disabled && $is_member);
    }

    public function showCreateWorld(User $user): bool
    {
        return $user->persistentUser->type_ == 'Member';
    }

    public function showMemberWorlds(User $user): bool
    {
        return $user->persistentUser->type_ == 'Member';
    }
    public function showMemberProjects(User $user): bool
    {
        return $user->persistentUser->type_ == 'Member';
    }
    public function showMemberTasks(User $user): bool
    {
        return $user->persistentUser->type_ == 'Member';
    }
    public function showMemberFavorites(User $user): bool
    {
        return $user->persistentUser->type_ == 'Member';
    }

    public function showInvites(User $user): bool
    {
        return $user->persistentUser->type_ == 'Member';
    }

    public function block(User $user): bool
    {
        return $user->persistentUser->type_ == 'Administrator';
    }

    public function request(User $user, Member $member)
    {
        $is_self = $user->user_id == $member->user_id;
        $is_friend = $user->persistentUser->member->friends->contains('id', $member->id);
        $maybe = Notification::where('is_request', true)->where('member_id', $user->persistentUser->member->id)->first();
        $has_request = isset($maybe) ? $maybe->members->contains('id', $member->id) : false;
        $is_disabled = $user->persistentUser->type_ == 'Blocked' || $user->persistentUser->type_ == 'Deleted';
        return !$is_disabled && !$is_self && !$is_friend && !$has_request;
    }
}
