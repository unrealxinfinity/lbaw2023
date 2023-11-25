<?php

use App\Http\Controllers\Auth\DeleteController;
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
use Laravel\Socialite\Facades\Socialite;

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
    return view('pages.homepage');
})->name('home');

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
          'password' => 'github',
          'user_id' => $persistentUser->id,
          'github_id' => $socialite->getId(),
          'github_token' => $socialite->token,
          'github_refresh_token' => $socialite->refreshToken
       ]);

       Member::create([
           'name' => 'New Member',
           'email' => $socialite->getEmail(),
           'user_id' => $persistentUser->id,
           'picture' => 'example.com'
       ]);

       Auth::login($user);
   }

   return redirect()->route('home');
});

Route::controller(SearchController::class)->group(function() {
    Route::get('/search', 'show')->name('search');//
});

Route::controller(WorldController::class)->group(function () {
    Route::post('/api/worlds/{id}/{username}', 'addMember');//
    Route::get('/worlds/{id}', 'show')->name('worlds.show');//
    Route::post('/worlds', 'create')->name('create-world');//
    Route::get('worlds/{id}/create-project', 'showProjectCreate')->name('project-create');//
    Route::get('/api/worlds/{id}/projects', 'searchProjects')->name('search-projects');//
    Route::post('/worlds/{id}/comment', 'comment')->name('world-comment');//
    Route::delete('/api/worlds/{id}/{username}', 'removeMember');
});

Route::controller(ProjectController::class)->group(function () {
    Route::post('/api/projects/{id}/{username}', 'addMember');//
    Route::get('/projects/{id}', 'show')->name('projects.show');//
    Route::delete('/projects/{id}', 'delete')->name('delete-project');//
    Route::post('/projects', 'create')->name('create-project');//
    Route::get('/api/projects/{id}/tasks', 'searchTask')->name('search-tasks');//
});

Route::controller(TagController::class)->group(function () {
    Route::post('/api/projects/{project_id}/tags/create', 'createProjectTag')->name('create-project-tag');
});

Route::controller(MemberController::class)->group(function () {
    Route::get('members/{username}', 'show'); //
    Route::get('/myworlds', 'showMemberWorlds');
    Route::get('/myprojects', 'showMemberProjects');//
    Route::get('/mytasks', 'showMemberTasks');//
    Route::put('/api/members/{username}', 'update')->name('update-member');//
    Route::get('/admin', 'list')->name('list-members');//
    Route::get('/members/{username}/edit', 'showEditProfile')->name('edit-member');
    Route::get('/create-world', 'showCreateWorld')->name('world-create');
});

Route::controller(TaskController::class)->group(function () {
    Route::post('/tasks', 'create')->name('create-task');//
    Route::get('/tasks/{id}', 'show')->name('tasks.show');//
    Route::post('/tasks/{id}/complete', 'complete')->name('complete-task');//
    Route::put('/tasks/{id}', 'edit')->name('edit-details');//
    Route::put('/api/tasks/{id}', 'move');
    Route::post('/api/tasks/{id}/{username}', 'assignMember');
    Route::post('/tasks/{id}/comment', 'comment')->name('task-comment');
});

// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login'); //
    Route::post('/login', 'authenticate'); //
    Route::get('/logout', 'logout')->name('logout');//
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');//
    Route::post('/register', 'register');//
});

Route::controller(DeleteController::class)->group(function () {
   Route::delete('/members/{username}', 'delete')->name('delete-member');//
});
