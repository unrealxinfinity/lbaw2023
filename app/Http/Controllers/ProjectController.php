<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateTagRequest;
use App\Http\Requests\AddMemberRequest;
use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\DeleteProjectRequest;
use App\Http\Requests\SearchTaskRequest;
use App\Models\Member;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;


class ProjectController extends Controller
{
    public function show(string $id): View
    {
        $project = Project::findOrFail($id);

        $this->authorize('show', $project);
        return view('pages.project', [
            'project' => $project,
            'tags'=> $project->tags
        ]);
    }

    public function create(CreateProjectRequest $request): RedirectResponse
    {
        $fields = $request->validated();

        $project = Project::create([
           'name' => $fields['name'],
           'description' => $fields['description'],
           'status' => 'Active',
           'picture' => 'pic',
            'world_id' => $fields['world_id']
        ]);

        $project->members()->attach(Member::where('user_id', auth()->user()->id)->first()->id, ['permission_level' => 'Project Leader']);

        return to_route('projects.show', ['id' => $project->id])->withSuccess('New World created!');
    }

    public function addMember(AddMemberRequest $request, string $project_id, string $username): JsonResponse
    {
        $fields = $request->validated();

        $project = Project::findOrFail($project_id);
        $member = User::where('username', $username)->first()->persistentUser->member;

        try
        {
            $is_admin = $member->worlds->where('id', $project->world_id)->first()->pivot->is_admin;
            $type = $is_admin ? 'World Administrator' : $fields['type'];

            $member->projects()->attach($project_id, ['permission_level' => $type]);

            return response()->json([
                'error' => false,
                'id' => $member->id,
                'username' => $username,
                'picture' => $member->picture
            ]);
        } catch (\Exception $e)
        {
            return response()->json([
                'error' => true,
                'username' => $username
            ]);
        }
    }
   
    public function delete(DeleteProjectRequest $request, string $id): View
    {
        $request->validated();

        $project = Project::findOrFail($id);
        $world_id = $project->world;

        $project->delete();

        return view('pages.world', [
            'world' => $world_id
        ]);
    }
    

    public function searchTask(SearchTaskRequest $request , string $id): JsonResponse
    {   
        $request->validated();
        $searchedTaskText = strval($request->query('search'));
        $searchedTaskText = strip_tags($searchedTaskText);     
        $tasks = Task::select('id','title','description','due_at','status','effort','priority')->whereRaw("searchedTasks @@ plainto_tsquery('english', ?) AND project_id = ?", [$searchedTaskText, $id])
            ->orderByRaw("ts_rank(searchedTasks, plainto_tsquery('english', ?)) DESC", [$searchedTaskText])
            ->get();
        $tasksJson = $tasks->toJson();
        return response()->json([
            'error' => false,
            'tasks'=> $tasksJson
        ]);
    }
}
