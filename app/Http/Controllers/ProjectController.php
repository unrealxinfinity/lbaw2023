<?php

namespace App\Http\Controllers;

use App\Models\Project;
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
}
