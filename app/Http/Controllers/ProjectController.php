<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProjectRequest;
use App\Models\Member;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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

    public function create(CreateProjectRequest $request): RedirectResponse
    {
        $fields = $request->validated();

        $project = Project::create([
           'name' => $fields['name'],
           'description' => $fields['name'],
           'status' => 'Active',
           'picture' => 'pic',
            'world_id' => $fields['world_id']
        ]);

        return redirect()->route('projects/' . $project->id)->withSuccess('New Project created!');
    }

    public function addMember(Request $request, string $project_id, string $member_id): void
    {
        $fields = $request->validate([
           'type' => [Rule::in('Member', 'Project Leader')]
        ]);

        $project = Project::findOrFail($project_id);
        $member = Member::findOrFail($member_id);

        $this->authorize('addMember', $project);

        $is_admin = $member->worlds->where('id', $project->world_id)[0]->pivot->is_admin;
        $type = $is_admin ? 'World Administrator' : $fields['type'];

        $member->projects->attach($project_id, ['type' => $type]);
    }
}
