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

    public function show(User $user, World $world): bool
    {
        // a guest or a normal user can see the world
        return (!Auth::check() || ($user->persistentUser->type_ !== "Blocked" && $user->persistentUser->type_ !== 'Deleted'));
    }

    public function create(User $user): bool
    {
        return $user->persistentUser->type_ !== "Blocked" && $user->persistentUser->type_ !== 'Deleted';
    }

    public function edit(User $user, World $world): bool
    {
        return (Auth::check() && $user->persistentUser->member->worlds->contains('id', $world->id) && $user->persistentUser->member->worlds->where('id', $world->id)->first()->pivot->is_admin);
    }
    public function delete(User $user, World $world): bool
    {
        return (Auth::check() && $user->persistentUser->member->worlds->contains('id', $world->id) && $user->persistentUser->member->worlds->where('id', $world->id)->first()->pivot->is_admin);
    }
    
    public function addMember(User $user, World $world): bool
    {
        return (Auth::check() && $user->persistentUser->member->worlds->contains('id', $world->id) && $user->persistentUser->member->worlds->where('id', $world->id)->first()->pivot->is_admin);
    }

    public function join(User $user, World $world): bool
    {
        return ($user->persistentUser->type_ === 'Member');
    }

    public function removeMember(User $user, World $world): bool
    {
        return ($user->persistentUser->member->worlds->where('id', $world->id)->first()->pivot->is_admin);
    }

    public function leave(User $user, World $world): bool
    {
        $is_owner = $world->owner_id === $user->persistentUser->member->id;
        return Auth::check() && $user->persistentUser->member->worlds->contains('id', $world->id) && !$is_owner;
    }

    public function comment(User $user, World $world): bool
    {
        return Auth::check() && ($user->persistentUser->type_ === 'Member') && ($user->persistentUser->member->worlds->contains($world->id));

    }
    public function searchProject(User $user, World $world): bool
    {
        return ($user->persistentUser->type_ != 'Blocked') && ($user->persistentUser->type_ != 'Deleted');

    }
}
