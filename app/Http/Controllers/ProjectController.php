<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function show(string $id): View
    {
        $project = Project::findOrFail($id);

        $this->authorize('show', $project);

        return view('pages.project', [
            'project' => $project
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
        $fields = $request->validate([
           'name' => 'alpha_num:ascii',
            'description' => 'string',
            'world_id' => 'exists:App\Models\World,id'
        ]);

        $project = Project::create([
           'name' => $fields['name'],
           'description' => $fields['name'],
           'status' => 'Active',
           'picture' => 'pic',
            'world_id' => $fields['world_id']
        ]);

        return redirect()->route('projects/' . $project->id)->withSuccess('New Project created!');
    }
}
