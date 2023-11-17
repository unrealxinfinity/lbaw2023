<?php

namespace App\Http\Controllers;

use App\Models\World;
use App\Models\User;
use App\Http\Requests\AddMemberToWorldRequest;
use App\Http\Requests\CreateWorldRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class WorldController extends Controller
{
    public function show(string $id): View
    {
        $world = World::findOrFail($id);

        $this->authorize('show', $world);

        return view('pages.world', [
            'world' => $world
        ]);
    }

    public function create(CreateWorldRequest $request): RedirectResponse
    {
        $fields = $request->validated();

        $world = World::create([
           'name' => $fields['name'],
           'description' => $fields['name'],
           'picture' => 'pic',
           'owner_id' => Auth::user()->persistentUser->member->id
        ]);

        return to_route('worlds.show', ['id' => $world->id])->withSuccess('New World created!');
    }

    public function addMember(AddMemberToWorldRequest $request,string $world_id, string $username): JsonResponse
    {   
        error_log('fodase');
        $fields = $request->validated();

        

        $world = World::findOrFail($world_id);
        $member = User::where('username', $username)->first()->persistentUser->member;

        $is_admin = $member->worlds->where('id', $world->id)[0]->pivot->is_admin;
        $type = $is_admin ? 'World Administrator' : $fields['type'];

        $member->worlds()->attach($world_id, ['permission_level' => $type]);

        return response()->json([
            'id' => $member->id,
            'username' => $username,
            'email' => $member->email,
            'permission_level' => $type
        ]);
    }
}
