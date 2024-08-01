<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\StagesController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\FeaturesController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\UsersConnectionsController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\TeamCollaboratorsController;
use App\Http\Controllers\FollowsController;
use App\Http\Controllers\ProjectTeamsController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TimerController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ClientProjectController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\ToDoController;

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

Route::get('/', function () {
    return view('auth/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [FeaturesController::class, 'dashboard'])->name('dashboard');
/*
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');

    // Handle registration form submission
    Route::post('register', [RegisterController::class, 'register']);
*/

    //Route::post('/profile/connect/{user}', [UsersConnectionsController::class, 'store'])->name('connections.store');
    Route::post('/profile/post', [PostsController::class, 'store'])->name('profile.store');

    // ---------------  USERS SECTION
    Route::get('/profile', function () {
        $user = auth()->user(); 
        return redirect()->route('profile.edit', ['user' => $user->id]);
    });
    Route::get('/user/edit', [ProfileController::class, 'edit'])->name('user.edit');
    Route::patch('/user', [ProfileController::class, 'update'])->name('user.update');
    Route::delete('/user', [ProfileController::class, 'destroy'])->name('user.destroy');
    Route::get('/changepassword', [NewPasswordController::class, 'create'])->name('password.create');

    // ---------------  USER PROFILE DETAILS SECTION

    Route::get('/profile/{user}/edit', [ProfilesController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/user', [ProfilesController::class, 'showUser'])->name('profile.showUser'); // logged user profile
    Route::get('/profile/{user}', [ProfilesController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfilesController::class, 'update'])->name('profile.update');

    // ---------------  TASKS SECTION

    Route::get('/tasks', [TasksController::class, 'index'])->name('tasks');
    Route::get('/task/new', [TasksController::class, 'new'])->name('task.new');
    Route::get('/task/{task}', [TasksController::class, 'show'])->name('task.show');
    Route::get('/task/{task}/edit', [TasksController::class, 'edit'])->name('task.edit');
    Route::get('/task/status/{id}', [TasksController::class, 'getStatus'])->name('tasks.getStatus');
    Route::post('/task', [TasksController::class, 'create'])->name('task.create');
    Route::post('/task/delete/', [TasksController::class, 'delete'])->name('task.delete');
    Route::post('/task/status', [TasksController::class, 'updateStatus'])->name('task.updateStatus');
    Route::post('/task/timer/stop', [TimerController::class, 'updateRecord'])->name('track.update-record');
    Route::post('/task/progress/update', [TasksController::class, 'updateProgress'])->name('task.progress.update');
    Route::patch('/task/{task}', [TasksController::class, 'update'])->name('task.update');

    // ---------------  CLIENTS SECTION
    Route::get('/clients', [ClientsController::class, 'index'])->name('teams');
    Route::get('/client/new', [ClientsController::class, 'new'])->name('client.new');
    Route::get('/client/{client}', [ClientsController::class, 'show'])->name('client.show');
    Route::get('/client/{client}/edit', [ClientsController::class, 'edit'])->name('client.edit');
    Route::post('/client', [ClientsController::class, 'create'])->name('client.store');
    Route::patch('/client/{client}', [ClientsController::class, 'update'])->name('client.update');

    // ---------------  TEAMS SECTION
    Route::get('/teams', [TeamsController::class, 'index'])->name('teams');
    Route::get('/team/new', [TeamsController::class, 'new'])->name('team.new');
    Route::post('/team', [TeamsController::class, 'create'])->name('team.create');
    Route::get('/team/{team}', [TeamsController::class, 'show'])->name('team.show');
    Route::get('/team/{team}/edit', [TeamsController::class, 'edit'])->name('team.edit');

    // ---------------  COMMENTS SECTION
    Route::get('/comment/new', [CommentsController::class, 'new'])->name('comment.new');
    Route::get('/comment/{comment}', [CommentsController::class, 'show'])->name('comment.show');
    Route::get('/comment/{comment}/edit', [CommentsController::class, 'edit'])->name('comment.edit');
    Route::post('/comment', [CommentsController::class, 'create'])->name('comment.store');
    Route::patch('/comment/{comment}', [CommentsController::class, 'update'])->name('comment.update');

    
    // ---------------  PROJECT SECTION
    Route::get('/projects', [ProjectsController::class, 'index'])->name('projects');
    Route::get('/project/new', [ProjectsController::class, 'new'])->name('project.new');
    Route::get('/project/{project}', [ProjectsController::class, 'show'])->name('project.show');
    Route::get('/project/{project}/edit', [ProjectsController::class, 'edit'])->name('project.edit');
    Route::get('/project/{project}/tasks', [ProjectsController::class, 'showTasks'])->name('project.tasks');
    Route::post('/project/stage/task', [TasksController::class, 'create'])->name('project.stage.task');
    Route::post('/project', [ProjectsController::class, 'create'])->name('project.create');
    Route::post('/project/{project}/settings', [SettingsController::class, 'storeOrUpdate'])->name('settings.update');
    Route::post('/project/stage', [StagesController::class, 'create'])->name('stage.create');
    Route::post('/project/team/add', [ProjectTeamsController::class, 'store'])->name('project.team.store');
    Route::patch('/project/update/{project}', [ProjectsController::class, 'update'])->name('project.update');
    //Route::get('/project/{project}/stage/{show_stage}', [ProjectsController::class, 'show_stage'])->name('project.stage.show');





    // ---------------  TIME TRACKER SECTION
    Route::get('/timesheet/', [TimerController::class, 'index']);
    Route::post('/timesheet/', [TimerController::class, 'index']);
    Route::get('/task/timer/open/{id}', [TimerController::class, 'getOpenRecord']);
    Route::get('/task/timer/{id}', [TimerController::class, 'getIndexInTask']);
    Route::get('/track/projects', [TimerController::class, 'getProjects']);
    Route::get('/track/{element}/{id}', [TimerController::class, 'getOpenTrack']);
    Route::post('/task/timer/', [TimerController::class, 'postRecord']);
    Route::post('/file/create', [FileController::class, 'create'])->name('file.create');

    // ---------------  PROJECT (VUE REQUEST) SECTION

    Route::post('/project/close/', [ProjectsController::class, 'close'])->name('project.close');
    Route::post('/project/open/', [ProjectsController::class, 'open'])->name('project.open');
    Route::patch('/project/{project}', [ProjectsController::class, 'update'])->name('project');
    Route::post('/project/client/add', [ClientProjectController::class, 'store'])->name('project.client.add');



    Route::patch('/team', [TeamsController::class, 'update'])->name('team.update');

    Route::get('/team/{team}/collaborator/{user}', [TeamCollaboratorsController::class, 'store'])->name('teamcollaborator.store');

    //----------------  PAGES SECTION
    Route::get('/extensions', [FeaturesController::class, 'plugins'])->name('plugins.show');
    Route::get('/about', [FeaturesController::class, 'about'])->name('about');

    // Route::post('/follows/{user}', [FollowsController::class, 'store'])->name('connections.store');
    Route::get('/collaborators', [ProfilesController::class, 'index'])->name('users');

    // ---------------  OTHER TOOLS SECTION
    Route::get('/tools/calendar/{display}', [FeaturesController::class, 'calendar'])->name('calendar.show');

    // ---------------  TO DO TOOL SECTION
    Route::post('/todo', [ToDoController::class, 'store'])->name('todo.store');
    Route::post('/todo/delete', [ToDoController::class, 'delete'])->name('todo.delete');
    Route::post('/todo/update', [ToDoController::class, 'update'])->name('todo.delete');
    Route::get('/todo/index/{element}/{id}', [ToDoController::class, 'index'])->name('todo.index');
    Route::get('/todo/general', [ToDoController::class, 'indexGeneral'])->name('todo.indexGeneral');

    // ---------------  SETTINGS SECTION
    Route::get('/settings/{model}/{element_id}/{group}/{setting}', [SettingsController::class, 'getGlobalSettings']);
    Route::post('/settings/create', [SettingsController::class, 'create'])->name('settings.create');
    Route::post('/settings/update', [SettingsController::class, 'update'])->name('settings.update');
});

require __DIR__ . '/auth.php';
