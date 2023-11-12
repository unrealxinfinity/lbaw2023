<?php

namespace App\Http\Controllers;

use App\Models\World;
use Illuminate\View\View;

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
}
