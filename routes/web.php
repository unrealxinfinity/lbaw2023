<?php

use App\Http\Controllers\Auth\DeleteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MemberController;
use App\Models\Member;
use App\Models\PersistentUser;
use App\Models\User;
use App\Models\World;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WorldController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\RecoverController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\FaqController;
use App\Models\Appeal;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



// Home
Route::get('/', function () {
    $params = [];
    if (Auth::check() && Auth::user()->persistentUser->type_ == 'Administrator') {
        $params = [
            'nMembers' => PersistentUser::where('type_', 'Member')->count(),
            'nAppeals' => Appeal::where('denied', false)->count()
        ];
    }

    return view('pages.homepage', $params);
})->name('home');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contacts', function () {
    return view('pages.contacts');
})->name('contacts');

Route::get('/main-features', function () {
    return view('pages.main-features');
})->name('main-features');

Route::get('/login/github', function () {
    return Socialite::driver('github')->redirect();
})->name('github-login');

Route::get('/login/callback', function () {
   $socialite = Socialite::driver('github')->stateless()->user();

   $user = User::where('github_id', $socialite->getId())->first();

   if ($user) {
       $user->github_token = $socialite->token;
       $user->github_refresh_token = $socialite->refreshToken;

       $user->save();

       Auth::login($user);
   }
   else {
       $persistentUser = PersistentUser::create([
           'type_' => 'Member'
       ]);

       $username = $socialite->getNickname();
       $counter = 1;
       error_log($socialite->getId());

       while (count(User::where('username', $username)->get()) == 1) {
           $username = $socialite->getNickname() . $counter;
           $counter++;
       }

       error_log($socialite->getId());
       $user = User::create([
          'username' => $username,
          'has_password' => false,
          'user_id' => $persistentUser->id,
          'github_id' => $socialite->getId(),
          'github_token' => $socialite->token,
          'github_refresh_token' => $socialite->refreshToken
       ]);

       Member::create([
           'name' => 'New Member',
           'email' => $socialite->getEmail(),
           'user_id' => $persistentUser->id,
           'picture' => null
       ]);

       Auth::login($user);
   }

   return redirect()->route('home');
});

Route::controller(SearchController::class)->group(function() {
    Route::get('/search', 'show')->name('search');
});

Route::controller(WorldController::class)->group(function () {
    Route::post('/api/worlds/{id}/favorite', 'favorite');
    Route::post('/api/worlds/{id}/invite', 'invite')->name('api-invite-world');
    Route::post('/worlds/{id}', 'join')->name('join-world');
    Route::delete('/api/worlds/{id}/{username}/remove', 'removeMember');
    Route::delete('worlds/{id}/{username}', 'leave')->name('leave-world');
    Route::delete('/api/worlds/{id}/{username}', 'leaveFromList');
    Route::get('/worlds/{id}', 'show')->name('worlds.show');
    Route::get('/worlds', 'showAll')->name('show-all-worlds');
    Route::post('/worlds', 'create')->name('create-world');
    Route::get('/worlds/{id}/edit', 'showEditWorld')->name('edit-world');
    Route::put('/worlds/{id}', 'update')->name('update-world');
    Route::get('/api/worlds/{id}/projects', 'searchProjects')->name('api-search-projects');
    Route::post('/worlds/{id}/comment', 'comment')->name('world-comment');
    Route::delete('/worlds/{id}', 'delete')->name('delete-world');
    Route::delete('/api/worlds/{id}', 'deleteFromList'); 
    Route::put('/api/worlds/{id}/assign', 'assignNewWorldAdmin')->name('api-assign-world-admin');
    Route::put('/api/worlds/{id}/demote', 'demoteWorldAdmin')->name('api-demote-world-admin');
    Route::get('/invite', 'showInvite')->name('show-invite');
    Route::get('/worlds/{id}/transfer', 'showTransfer')->name('show-transfer');
    Route::post('/worlds/{id}/transfer', 'transfer')->name('transfer-world');
});

Route::controller(ProjectController::class)->group(function () {
    Route::post('/api/projects/{id}/favorite', 'favorite');
    Route::post('/api/projects/{id}/{username}', 'addMember');
    Route::delete('/api/projects/{id}/{username}', 'removeMember');
    Route::get('/projects/{id}', 'show')->name('projects.show');
    Route::delete('/projects/{id}', 'delete')->name('delete-project');
    Route::post('/projects', 'create')->name('create-project');
    Route::get('/projects/{id}/edit', 'showEditProject')->name('edit-project');
    Route::put('/projects/{id}', 'update')->name('update-project');
    Route::post('/projects/{id}/archive', 'archive')->name('archive-project');
    Route::get('/api/projects/{id}/tasks', 'searchTask')->name('api-search-tasks');
    Route::delete('projects/{id}/{username}', 'leave')->name('leave-project');
    Route::put('/api/projects/{id}/assign', 'promoteToPL')->name('api-assign-project-leader');
    Route::put('/api/projects/{id}/demote', 'demotePL')->name('api-demote-project-leader');
});

Route::controller(TagController::class)->group(function () {
    Route::post('/api/projects/{project_id}/tags/create', 'createProjectTag')->name('api-create-project-tag');
    Route::post('/api/worlds/{id}/tags/create', 'createWorldTag')->name('api-create-world-tag');
    Route::post('/api/members/{username}/tags/create', 'createMemberTag')->name('api-create-member-tag');
    Route::delete('/api/projects/{project_id}/tags/delete/{tag_id}', 'deleteProjectTag')->name('api-delete-project-tag');
    Route::delete('/api/worlds/{id}/tags/delete/{tag_id}', 'deleteWorldTag')->name('api-delete-world-tag');
    Route::delete('/api/members/{username}/tags/delete/{tag_id}', 'deleteMemberTag')->name('api-delete-member-tag');
});

Route::controller(MemberController::class)->group(function () {
    Route::get('members/{username}', 'show')->name('members.show');
    Route::get('/myworlds', 'showMemberWorlds')->name('show-worlds-list');
    Route::get('/myprojects', 'showMemberProjects')->name('show-projects-list');
    Route::get('/mytasks', 'showMemberTasks')->name('show-tasks-list');
    Route::get('/myfavorites', 'showMemberFavorites');
    Route::put('/members/{username}', 'update')->name('update-member');
    Route::get('/admin/members', 'list')->name('list-members');
    Route::get('/members/{username}/edit', 'showEditProfile')->name('edit-member');
    Route::get('/create-world', 'showCreateWorld')->name('world-create');
    Route::get('/api/allBelongings','getAllBelongings')->name('api-all-belongings');
    Route::post('/members/{username}/block', 'block')->name('block-member');
    Route::post('/members/{username}/unblock', 'unblock')->name('unblock-member');
    Route::post('/appeals/{id}', 'denyAppeal')->name('deny-appeal');
    Route::get('/admin/appeals', 'allAppeals')->name('admin-appeals');
    Route::get('/invites', 'showInvites')->name('show-invites');
    Route::get('/appeal', 'showAppeal')->name('show-appeal');
    Route::post('/appeal/{id}', 'appeal')->name('appeal');
    Route::get('/myfriends', 'showFriends')->name('friends');
    Route::delete('/friends/{id}', 'deleteFriend')->name('api-remove-friend');
});

Route::controller(TaskController::class)->group(function () {
    Route::post('/api/tasks', 'create')->name('api-create-task');
    Route::get('/tasks/{id}', 'show')->name('tasks.show');
    Route::post('/tasks/{id}/complete', 'complete')->name('complete-task');
    Route::put('/tasks/{id}', 'edit')->name('edit-details');
    Route::put('/api/tasks/{id}', 'move');
    Route::post('/api/tasks/{id}/{username}', 'assignMember');
    Route::delete('/api/tasks/{id}/{username}', 'removeMember');
    Route::post('/tasks/{id}/comment', 'comment')->name('task-comment');
    Route::delete('/tasks/{id}', 'delete')->name('delete-task');
});

Route::controller(CommentController::class)->group(function () {
   Route::put('/comments/{id}', 'edit')->name('edit-comment');
});

// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login'); 
    Route::post('/login', 'authenticate'); 
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});

Route::controller(DeleteController::class)->group(function () {
   Route::delete('/members/{username}', 'delete')->name('delete-member');
   Route::get('/members/{username}/delete', 'showConfirmation')->name('delete-confirmation');
});

Route::controller(NotificationController::class)->group(function () {
    Route::get('/api/notifications', 'listNotifications')->name('api-listNotifications');
    Route::post('/api/notifications', 'createNotification')->name('api-createNotification');
    Route::delete('/api/notifications','clearNotifications')->name('api-clearNotification');
    Route::delete('/api/notifications/{id}', 'clearSingle')->name('api-clearSingleNotification');
    Route::post('/api/accept/{id}', 'acceptRequest')->name('api-accept-request');
    Route::post('/api/request/{username}', 'friendRequest');
});

Route::controller(FileController::class)->group(function () {
   Route::post('/members/upload/{id}', 'upload');
   Route::post('/projects/upload/{id}', 'upload');
   Route::post('/worlds/upload/{id}', 'upload');
});

Route::controller(RecoverController::class)->group(function () {
    Route::get('/recover', 'showRecoverForm');
    Route::post('/recover', 'send')->name('send-recover');
    Route::get('/reset', 'showResetForm');
    Route::post('/reset', 'reset')->name('reset-password');
});
Route::controller(FaqController::class)->group(function () {
    Route::get('/faq', 'show')->name('show-faqs');
    Route::post('/faq', 'add')->name('add-faq');
    Route::delete('/faq', 'delete')->name('delete-faq');
});