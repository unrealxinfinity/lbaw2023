<?php

use App\Http\Controllers\MemberController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WorldController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TagController;
use App\Models\Project;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CardController;
use App\Http\Controllers\ItemController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

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
//Route::redirect('/', '/login');
Route::get('/', function () {
    return view('pages.homepage');
})->name('home');

// Cards
Route::controller(CardController::class)->group(function () {
    Route::get('/cards', 'list')->name('cards');
    Route::get('/cards/{id}', 'show');
});

Route::controller(WorldController::class)->group(function () {
   Route::get('/worlds/{id}', 'show');
});

Route::controller(ProjectController::class)->group(function () {
    Route::post('/api/projects/{id}/{username}', 'addMember');
    Route::get('/projects/{id}', 'show')->name('projects.show');
});
Route::controller(TagController::class)->group(function () {
   //Route::post('/projects/{id}', 'createProjectTag')->name('create-project-tag');
});
Route::controller(MemberController::class)->group(function () {
    Route::get('members/{id}', 'show');
});

Route::controller(MemberController::class)->group(function () {
    Route::get('/myworlds', 'showMemberWorlds');
    Route::put('/api/members/{id}', 'update')->name('update-member');
});

Route::controller(TaskController::class)->group(function () {
    Route::post('/tasks/create', 'create')->name('create-task');
});


// API
Route::controller(CardController::class)->group(function () {
    Route::put('/api/cards', 'create');
    Route::delete('/api/cards/{card_id}', 'delete');
});

Route::controller(ItemController::class)->group(function () {
    Route::put('/api/cards/{card_id}', 'create');
    Route::post('/api/item/{id}', 'update');
    Route::delete('/api/item/{id}', 'delete');
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
