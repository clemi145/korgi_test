<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\FileController;
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
Route::middleware(['auth:sanctum', 'verified'])->post('/gruppen', [GroupController::class, 'store']);

Route::group(['prefix' => 'gruppen', "middleware" => ['auth:sanctum', 'verified']], function () {
    Route::get('{url}', [GroupController::class, 'show'])->name("group.show");
    Route::get('{url}/users', [GroupController::class, 'users'])->name('group.users');
    Route::get("{url}/files", [FileController::class, "show"])->name("group.files.show");
    Route::post("files/post", [FileController::class, "store"])->name("group.files.store");
    Route::post("files/get", [FileController::class, "download"])->name("group.files.download");

    Route::get("join/{uuid}", [GroupController::class, 'join'])->name("group.join.show");
    Route::post('join', [UserController::class, "store"])->name("group.join");

    Route::post("leave", [GroupController::class, "leave"])->name("group.leave");

    Route::post("delete", [GroupController::class, "delete"])->name("group.delete");
});

// Users
Route::group(["prefix" => "users"], function () {
    Route::post("delete", [UserController::class, "delete"])->name("user.delete");
    Route::post("remove", [UserController::class, "remove"])->name("user.remove");
});

// EVENTS
Route::inertia('termine', "Chat/Event/Events")->name('events.show');

// SETTINGS
Route::inertia('einstellungen', "Navigation/Settings")->name('settings.show');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
