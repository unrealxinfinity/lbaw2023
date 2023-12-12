<?php

namespace App\Policies;

use App\Models\User;
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
        return ($user->persistentUser->type_ !== "Blocked" && $user->persistentUser->type_ !== 'Deleted');
    }

    public function create(User $user): bool
    {
        return $user->persistentUser->type_ !== "Blocked" && $user->persistentUser->type_ !== 'Deleted';
    }

    public function edit(?User $user, World $world): bool
    {
        if($user == null) return true;
        return (Auth::check() && $user->persistentUser->member->worlds->contains('id', $world->id) && $user->persistentUser->member->worlds->where('id', $world->id)->first()->pivot->is_admin);
    }
    public function delete(?User $user, World $world): bool
    {
        if ($user == null) return false;
        if ($user->persistentUser->type_ === 'Administrator') return true;
        return ($user->persistentUser->member->worlds->contains('id', $world->id) && $user->persistentUser->member->worlds->where('id', $world->id)->first()->pivot->is_admin);
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
        return ($user->persistentUser->type_ === 'Member' && !$user->persistentUser->member->worlds->contains('id', $world->id));
    }

    public function removeMember(User $user, World $world): bool
    {
        return ($user->persistentUser->member->worlds->where('id', $world->id)->first()->pivot->is_admin);
    }
    public function assignWorldAdmin(User $user, World $world): bool
    {   
        return ($user->persistentUser->member->worlds->where('id', $world->id)->first()->pivot->is_admin);
    }
    public function removeAdmin(User $user, World $world): bool
    {
        return ($user->persistentUser->member->id == $world->owner()->get()->first()->id);
    }

    public function leave(?User $user, World $world): bool
    {
        if ($user == null) return false;
        if($user->persistentUser->type_ === 'Administrator') return false;
        $is_owner = $world->owner_id === $user->persistentUser->member->id;
        return $user->persistentUser->member->worlds->contains('id', $world->id) && !$is_owner;
    }

    public function comment(User $user, World $world): bool
    {
        return Auth::check() && ($user->persistentUser->type_ === 'Member') && ($user->persistentUser->member->worlds->contains($world->id));

    }
    public function searchProject(User $user, World $world): bool
    {
        return ($user->persistentUser->type_ != 'Blocked') && ($user->persistentUser->type_ != 'Deleted');
    }

    public function favorite(User $user, World $world): bool
    {
        return ($user->persistentUser->type_ != 'Blocked') && ($user->persistentUser->type_ != 'Deleted');
    }

    public function transfer(User $user, World $world): bool
    {
        return (Auth::check() && $world->owner_id === $user->persistentUser->member->id);
    }
    public function worldTagCreate(User $user, World $world): bool
    {
        $is_banned = ($user->persistentUser->type_ == 'Blocked');
        $is_deleted = ($user->persistentUser->type_ == 'Deleted');
        $is_member = ($user->persistentUser->type_ === 'Member') && $user->persistentUser->member->worlds->contains($world->id);
        return !$is_banned && !$is_deleted && $is_member;
    }
    public function deleteWorldTag(User $user, World $world): bool
    {   
        $type = $user->persistentUser->type_;
        $is_disabled = $type === 'Blocked' || $type === 'Deleted';
        $is_member = $type === 'Member' && $user->persistentUser->member->worlds->contains('id', $world->id);
        return (!$is_disabled && $is_member);
    }
}
