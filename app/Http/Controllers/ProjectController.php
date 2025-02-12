<?php

namespace App\Http\Controllers;
use App\Http\Requests\AddMemberRequest;
use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\DeleteProjectRequest;
use App\Http\Requests\LeaveProjectRequest;
use App\Http\Requests\AssignProjectLeaderRequest;
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
use App\Http\Controllers\NotificationController;
use App\Models\ProjectPermission;
use Illuminate\Support\Facades\Auth;



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
           'picture' => null,
            'world_id' => $fields['world_id']
        ]);
        
        $project->members()->attach(Member::where('user_id', auth()->user()->id)->first()->id, ['permission_level' => ProjectPermission::Leader->value]);

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

        try
        {
            $member = User::where('username', $username)->first()->persistentUser->member;
            $type = $fields['type'];

            $member->projects()->attach($project_id, ['permission_level' => $type]);
            $can_remove = ($type=='Project Leader')? $this->authorize('removeLeader', $project) : $this->authorize('removeMember', $project);
            $can_move = $this->authorize('AssignProjectLeader', $project);
            NotificationController::ProjectNotification($project,$project->world_id,$member->name.' joined the');
            return response()->json([
                'error' => false,
                'id' => $member->id,
                'username' => $username,
                'project_id' => $project->id,
                'picture' => $member->getProfileImage(),
                'is_leader' => $fields['type']=='Project Leader',
                'can_remove' => $can_remove,
                'can_move' => $can_move,
                'task' => false
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
        $member = Member::where('user_id', auth()->user()->id)->first();
        $project->save();
        NotificationController::ProjectNotification($project,$project->world->id,$member->name .' archived');
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
    public function promoteToPL(AssignProjectLeaderRequest $request,string $id): JsonResponse{
      
        $fields = $request->validated();
      
        $project = Project::findOrFail($id);
        $member = User::where('username', $fields['username'])->first()->persistentUser->member;
        
        try{
            if($fields['username'] == Auth::user()->persistentUser->username)
                throw new \Exception('You can\'t promote yourself');
            $member->projects()->updateExistingPivot($id ,['permission_level' => ProjectPermission::Leader->value]);
            NotificationController::ProjectNotification($project,$project->world_id,$member->name.' was promoted in the ');
            return response()->json([
                'error' => false,
                'username' => $fields['username'],
                'message' => 'Promoted'
            ]);
        } catch (\Exception $e){
            return response()->json([
                'error' => true,
                'username' => $fields['username'],
                'message' => $e->getMessage()
            ]);
        }
    }
    public function demotePL(AssignProjectLeaderRequest $request,$id): JsonResponse{
        error_log("here");
        $fields = $request->validated();
        $project = Project::findOrFail($id);
        error_log($project);
        $member = User::where('username', $fields['username'])->first()->persistentUser->member;
        error_log($member);
        try{
            if($fields['username'] == Auth::user()->persistentUser->username)
                throw new \Exception('You can\'t demote yourself');
            $member->projects()->updateExistingPivot($id, ['permission_level' => ProjectPermission::Member->value]);
            NotificationController::ProjectNotification($project,$project->world_id,$member->name.' was demoted in the ');
            return response()->json([
                'error' => false,
                'username' => $fields['username'],
                'message' => 'Demoted'
                
            ]);
        } catch (\Exception $e){
            return response()->json([
                'error' => true,
                'username' => $fields['username'],
                'message' => $e->getMessage()
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
            'world' => $world_id,
            'subform' => false
        ]);
    }
    

    public function searchTask(SearchTaskRequest $request , string $id): JsonResponse
    {   
        $request->validated();
        
        $searchedTaskText = strval($request->query('search'));
        $searchedTaskText = strip_tags($searchedTaskText);  
        $order= $request->query('order');
        $type = $request->query('type');
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

    public function favorite(string $id): JsonResponse
    {
        $project = Project::findOrFail($id);
        $this->authorize('favorite', $project);
        $member = Auth::user()->persistentUser->member;

        try {
            if ($member->favoriteProject->contains('id', $id)) {
                $member->favoriteProject()->detach($id);
                $favorite = false;
            } else {
                $member->favoriteProject()->attach($id);
                $favorite = true;
            }

            $member->save();
            
            return response()->json([
                'error' => false,
                'favorite' => $favorite,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => true
            ]);
        }
        
    }
}
