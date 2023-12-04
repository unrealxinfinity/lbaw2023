<?php

namespace App\Http\Controllers;
use App\Http\Requests\AddMemberRequest;
use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\DeleteProjectRequest;
use App\Http\Requests\LeaveProjectRequest;
use App\Http\Requests\RemoveMemberRequest;
use App\Http\Requests\SearchTaskRequest;
use App\Http\Requests\EditProjectRequest;
use App\Models\Member;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationController;
class ProjectController extends Controller
{
    public function show(string $id): View
    {
        $project = Project::findOrFail($id);

        $this->authorize('show', $project);
        return view('pages.project', [
            'project' => $project,
            'tags'=> $project->tags,
            'edit' => false
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

        NotificationController::ProjectNotification($project,$fields['world_id'],'Created');

        return to_route('projects.show', ['id' => $project->id])->withSuccess('New Project created!');
    }

    public function update(EditProjectRequest $request, string $id): RedirectResponse
    {
        $fields = $request->validated();

        $project = Project::findOrFail($id);

        $project->name = $fields['name'];
        $project->status = $fields['status'];
        $project->description = $fields['description'];
        
        $project->save();

        return redirect()->route('projects.show', $id);
    }

    public function addMember(AddMemberRequest $request, string $project_id, string $username): JsonResponse
    {
        $fields = $request->validated();

        $project = Project::findOrFail($project_id);
        $member = User::where('username', $username)->first()->persistentUser->member;

        try
        {
            $type = $fields['type'];

            $member->projects()->attach($project_id, ['permission_level' => $type]);
            $can_remove = Auth::user()->persistentUser->member->projects->where('id', $project->id)->first()->pivot->permission_level == 'Project Leader';
            NotificationController::ProjectNotification($project,$project->world_id,$member->name.' joined the');
            return response()->json([
                'error' => false,
                'id' => $member->id,
                'username' => $username,
                'project_id' => $project->id,
                'picture' => $member->picture,
                'is_leader' => $fields['type']=='Project Leader',
                'can_remove' => $can_remove
            ]);
        } catch (\Exception $e)
        {
            return response()->json([
                'error' => true,
                'username' => $username,
                'parent' => 'world',
                'child' =>'project'
            ]);
        }
    }

    public function archive(string $id): RedirectResponse
    {
        $project = Project::findOrFail($id);
        $this->authorize('edit', $project);

        $project->status = 'Archived';

        $project->save();

        return redirect()->route('projects.show', $id);
    }

    public function removeMember(RemoveMemberRequest $request, string $project_id, string $username): JsonResponse
    {
        $fields = $request->validated();

        $project = Project::findOrFail($project_id);
        $member = User::where('username', $username)->first()->persistentUser->member;
        error_log($username);

        try
        {
            $member->projects()->detach($project_id);

            return response()->json([
                'error' => false,
                'id' => $project->id,
                'member_id' => $member->id,
            ]);
        } catch (\Exception $e)
        {
            return response()->json([
                'error' => true,
                'id' => $project->id,
            ]);
        }
    }

    public function leave(LeaveProjectRequest $request, string $id): RedirectResponse
    {
        try{
            $request->validated();
            $project = Project::findOrFail($id);
            $project->members()->detach(Member::where('user_id', auth()->user()->id)->first()->id);
            $member = Member::where('user_id', auth()->user()->id)->first();
            NotificationController::ProjectNotification($project,$project->world_id,$member->name.' left the');
            return to_route('worlds.show', ['id' => $project->world_id])->withSuccess('You have left the project!');
        } catch (\Exception $e){
            return to_route('projects.show', ['id' => $id])->withSuccess('You can\'t leave this project!');
        }
    }
   
    public function delete(DeleteProjectRequest $request, string $id): View
    {
        $request->validated();

        $project = Project::findOrFail($id);
        $world_id = $project->world;
        NotificationController::ProjectNotification($project,$world_id->id,'Deleted');
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
        $order= $request->query('order');
        $order = strip_tags($order);
        $arr = explode(' ', $searchedTaskText);
        for ($i = 0; $i < count($arr); $i++) {
            $arr[$i] = $arr[$i] . ':*';
        }
        $searchedTaskText = implode(' | ', $arr);

        $tasks = Task::select('id','title','description','due_at','status','effort','priority')->whereRaw("searchedTasks @@ plainto_tsquery('english', ?) AND project_id = ?", [$searchedTaskText, $id])
            ->orderByRaw("ts_rank(searchedTasks, plainto_tsquery('english', ?)) DESC", [$searchedTaskText])
            ->get();

        
        if($order == 'A-Z'){
            $tasks = $tasks->sortByDesc('title')->values();
        }
        else if($order == 'Z-A'){
            $tasks = $tasks->sortBy('title')->values();
        }
        else if($order == 'EffortAscendent'){
            $tasks = $tasks->sortBy('effort')->values();
        }
        else if($order == 'EffortDescendent'){
            $tasks = $tasks->sortByDesc('effort')->values();
        }
        
        else if($order == 'DueDateAscendent'){
            $tasks = $tasks->sortByDesc("due_at")->values();
            
        }
        else if($order == 'DueDateDescendent'){
            $tasks = $tasks->sortBy("due_at")->values();
            
        }
        $tasksJson = $tasks->toJson();
        return response()->json([
            'error' => false,
            'tasks'=> $tasksJson
        ]);
    }

    public function showEditProject(string $id): View
    {
        $project = Project::findOrFail($id);

        $this->authorize('edit', $project);

        return view('pages.project', [
            'project' => $project,
            'tags'=> $project->tags,
            'edit' => true
        ]);
    }
}
