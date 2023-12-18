<?php

namespace App\Policies;

use App\Models\Member;
use App\Models\User;
use App\Models\Notification;
use App\Models\UserType;

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
        $is_admin = $type === UserType::Administrator->value;
        $is_disabled = $type === UserType::Blocked->value || $type === UserType::Deleted->value;
        $is_member = $member->user->id == $user->id;
        return $is_admin || (!$is_disabled && $is_member);
        //return ($user->persistentUser->type_ === 'Administrator') || ($member->user->id === $user->id);
    }

    public function appeal(User $user): bool
    {
        $is_blocked = $user->persistentUser->type_ == UserType::Blocked->value;
        $has_appeal = isset($user->persistentUser->member->appeal);
        return $is_blocked && !$has_appeal;
    }

    public function create(User $user, Member $member): bool
    {
        return $user->persistentUser->type_ === UserType::Administrator->value;
    }

    public function list(User $user): bool
    {
        return $user->persistentUser->type_ === UserType::Administrator->value;
    }
    public function showSearchResults(User $user,Member $member): bool
    {   
        $type = $user->persistentUser->type_; 
        $is_disabled = $type === UserType::Blocked->value || $type === UserType::Deleted->value;
        $is_member = $member->user_id == $user->id;
        return (!$is_disabled && $is_member);
    }

    public function showCreateWorld(User $user): bool
    {
        return $user->persistentUser->type_ == UserType::Member->value;
    }

    public function showMemberWorlds(User $user): bool
    {
        return $user->persistentUser->type_ == UserType::Member->value;
    }
    public function showMemberProjects(User $user): bool
    {
        return $user->persistentUser->type_ == UserType::Member->value;
    }
    public function showMemberTasks(User $user): bool
    {
        return $user->persistentUser->type_ == UserType::Member->value;
    }
    public function showMemberFavorites(User $user): bool
    {
        return $user->persistentUser->type_ == UserType::Member->value;
    }

    public function showInvites(User $user): bool
    {
        return $user->persistentUser->type_ == UserType::Member->value;
    }

    public function block(User $user): bool
    {
        return $user->persistentUser->type_ == UserType::Administrator->value;
    }
    public function assignOwn(User $user, Member $member): bool
    {  
        return $user->id == $member->user_id;
    }

    public function request(User $user, Member $member)
    {
        if($user->persistentUser->type_ === UserType::Administrator->value) return false;
        $is_self = $user->user_id == $member->user_id;
        $is_friend = $user->persistentUser->member->friends->contains('id', $member->id);
        $maybe = Notification::where('is_request', true)->where('member_id', $user->persistentUser->member->id)->first();
        $has_request = isset($maybe) ? $maybe->members->contains('id', $member->id) : false;
        $is_disabled = $user->persistentUser->type_ == UserType::Blocked->value || $user->persistentUser->type_ == UserType::Deleted->value;
        return !$is_disabled && !$is_self && !$is_friend && !$has_request;
    }
    public function memberTagCreate(User $user, Member $member): bool
    {
        $is_disabled = $user->persistentUser->type_ == UserType::Blocked->value || $user->persistentUser->type_ == UserType::Deleted->value;
        $is_self = $user->persistentUser->member->id == $member->id;
        return !$is_disabled && $is_self;
    }
    public function deleteMemberTag(User $user, Member $member): bool
    {   
        $type = $user->persistentUser->type_;
        $is_disabled = $type === UserType::Blocked->value || $type === UserType::Deleted->value;
        $is_member = $type === UserType::Member->value && ($user->persistentUser->member->id == $member->id);
        return (!$is_disabled && $is_member);
    }
}
