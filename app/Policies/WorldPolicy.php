<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserType;
use App\Models\World;
use Illuminate\Support\Facades\Auth;

class WorldPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function show(?User $user, World $world): bool
    {
        if($user == null) return true;
        return ($user->persistentUser->type_ !== UserType::Deleted->value && $user->persistentUser->type_ !== UserType::Blocked->value);
    }

    public function create(User $user): bool
    {
        return $user->persistentUser->type_ !== "Blocked" && $user->persistentUser->type_ !== UserType::Deleted->value;
    }

    public function edit(?User $user, World $world): bool
    {
        if($user == null) return false;
        else if ($user->persistentUser->type_ === UserType::Administrator->value) return false;
        return (Auth::check() && $user->persistentUser->member->worlds->contains('id', $world->id) && $user->persistentUser->member->worlds->where('id', $world->id)->first()->pivot->is_admin);
    }
    public function delete(?User $user, World $world): bool
    {
        if ($user == null) return false;
        if ($user->persistentUser->type_ === UserType::Administrator->value) return true;
        return ($user->persistentUser->member->worlds->contains('id', $world->id) && $world->owner_id === $user->persistentUser->member->id);
    }
    
    public function addMember(User $user, World $world): bool
    {
        if(Auth::check()){
            return ($user->persistentUser->member->worlds->contains('id', $world->id) && $user->persistentUser->member->worlds->where('id', $world->id)->first()->pivot->is_admin);
        } else {
            return false;
        }
        
    }

    public function join(User $user, World $world): bool
    {
        return ($user->persistentUser->type_ === UserType::Member->value && !$user->persistentUser->member->worlds->contains('id', $world->id));
    }

    public function removeMember(User $user, World $world): bool
    {
        if ($user == null) return false;
        else if ($user->persistentUser->type_ === UserType::Administrator->value) return false;

        return ($user->persistentUser->member->worlds->contains('id', $world->id) && $user->persistentUser->member->worlds->where('id', $world->id)->first()->pivot->is_admin);
    }
    public function assignWorldAdmin(User $user, World $world): bool
    {   
        if ($user == null) return false;
        else if ($user->persistentUser->type_ === UserType::Administrator->value) return false;
        else if(!$user->persistentUser->member->worlds->contains('id', $world->id)) return false;
        return ($user->persistentUser->member->worlds->where('id', $world->id)->first()->pivot->is_admin);
    }
    public function removeAdmin(User $user, World $world): bool
    {
        if ($user == null) return false;
        else if ($user->persistentUser->type_ === UserType::Administrator->value) return false;
        return ($user->persistentUser->member->id == $world->owner()->get()->first()->id);
    }

    public function leave(?User $user, World $world): bool
    {   
        if ($user == null) return false;
        if($user->persistentUser->type_ === UserType::Administrator->value) return false;
        $is_owner = $world->owner_id === $user->persistentUser->member->id;
        return $user->persistentUser->member->worlds->contains('id', $world->id) && !$is_owner;
    }

    public function comment(User $user, World $world): bool
    {
        return Auth::check() && ($user->persistentUser->type_ === UserType::Member->value) && ($user->persistentUser->member->worlds->contains($world->id));

    }
    public function searchProject(User $user, World $world): bool
    {
        return ($user->persistentUser->type_ != UserType::Blocked->value) && ($user->persistentUser->type_ != UserType::Deleted->value);
    }

    public function favorite(User $user, World $world): bool
    {
        return ($user->persistentUser->type_ != UserType::Blocked->value) && ($user->persistentUser->type_ != UserType::Deleted->value);
    }

    public function transfer(User $user, World $world): bool
    {
        return (Auth::check() && $user->persistentUser->type_ !== UserType::Administrator->value && $world->owner_id === $user->persistentUser->member->id);
    }
    public function worldTagCreate(User $user, World $world): bool
    {
        $is_banned = ($user->persistentUser->type_ == UserType::Blocked->value);
        $is_deleted = ($user->persistentUser->type_ == UserType::Deleted->value);
        $is_member = ($user->persistentUser->type_ === UserType::Member->value) && $user->persistentUser->member->worlds->contains($world->id);
        return !$is_banned && !$is_deleted && $is_member;
    }
    public function deleteWorldTag(User $user, World $world): bool
    {   
        $type = $user->persistentUser->type_;
        $is_disabled = $type === UserType::Blocked->value || $type === UserType::Deleted->value;
        $is_member = $type === UserType::Member->value && $user->persistentUser->member->worlds->contains('id', $world->id);
        return (!$is_disabled && $is_member);
    }
}
