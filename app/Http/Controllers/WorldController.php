<?php

namespace App\Http\Controllers;

use App\Models\World;
use App\Http\Requests\CreateWorldRequest;
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
}
