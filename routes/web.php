<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LoginController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// HOME
Route::get('/', function () {
    if (!Auth::check()) {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    } else {
        return redirect()->route("groups.show");
    }
})->name("home");

// GROUPS
Route::middleware(['auth:sanctum', 'verified'])->get('/gruppen', [GroupController::class, 'index'])->name('groups.show');
Route::middleware(['auth:sanctum', 'verified'])->post('/gruppen', [GroupController::class, 'store'])->name('group.store');

Route::group(['prefix' => 'gruppen', "middleware" => ['auth:sanctum', 'verified']], function () {
    Route::get('{url}', [GroupController::class, 'show'])->name("group.show");
    Route::get('{url}/users', [GroupController::class, 'users'])->name('group.users');
    Route::get("{url}/files", [FileController::class, "show"])->name("group.files.show");
    Route::post("files/post", [FileController::class, "store"])->name("group.files.store");
    Route::post("files/get", [FileController::class, "download"])->name("group.files.download");

    Route::get("join/{uuid}", [GroupController::class, 'join'])->name("group.join.show");
    Route::post('join', [UserController::class, "store"])->name("group.join");

    Route::post("update", [GroupController::class, "update"])->name("group.update");

    Route::post("leave", [GroupController::class, "leave"])->name("group.leave");

    Route::post("delete", [GroupController::class, "delete"])->name("group.delete");

    Route::post("set", [GroupController::class, "set"])->name("group.set");

    Route::post("get", [GroupController::class, "get"])->name("group.get");
});

// Users
Route::group(["prefix" => "users"], function () {
    Route::post("delete", [UserController::class, "delete"])->name("user.delete");
    Route::post("remove", [UserController::class, "remove"])->name("user.remove");
});

// EVENTS
Route::get('termine', function () {
    return Inertia::render("Events/Events", [
        "user" => User::find(Auth::user()->id),
        "groups" => User::find(Auth::user()->id)->allTeams()
    ]);
})->name('events.show');

// SETTINGS
Route::get('einstellungen', function () {
    return Inertia::render("Settings/Settings", [
        "user" => User::find(Auth::user()->id),
        "groups" => User::find(Auth::user()->id)->allTeams()
    ]);
})->name('settings.show');

Route::inertia('offline', "Offline")->name('offline');
Route::inertia('stats', "Statistics")->name('stats');
Route::inertia('impressum', "Imprint")->name('imprint');
Route::inertia('datenschutz', "Privacy")->name('tos');

Route::get('auth/google', [LoginController::class, 'redirectToGoogle'])->name("auth.google");
Route::get('auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

/*
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
*/
