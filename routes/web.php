<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ChatController;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/gruppen', [GroupController::class, 'index'])->name('groups.show');
Route::middleware(['auth:sanctum', 'verified'])->post('/gruppen', [GroupController::class, 'store']);

Route::group(['prefix' => 'gruppen'], function () {
    Route::get('{name}', [ChatController::class, 'show'])->name("group.show");//[GroupController::class, 'group'])->name('group.show');
    // Route::get('{id}/{type}', [ChatController::class, 'show'])->name('chat.show');
});

Route::middleware(['auth:sanctum', 'verified'])->get("/join/{uuid}", [GroupController::class, 'join'])->name("join");
Route::middleware('auth:sanctum', 'verified')->post('/join', [UserController::class, "store"]);

Route::inertia('/termine', "Chat/Event/Events")->name('events.show');

Route::inertia('/einstellungen', "Navigation/Settings")->name('settings.show');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
