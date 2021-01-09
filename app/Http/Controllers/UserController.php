<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Jetstream\Events\TeamMemberAdded;

class UserController extends Controller
{
    function store(Request $request)
    {

        Log::info("Storing User");

        $user = Auth::user();
        $team = Team::where("uuid", $request->uuid)->first();

        if (DB::table('team_user')->where('team_id', $team->id)->first() && DB::table('team_user')->where('user_id', $user->id)->first()) {
            Log::info("User already in Database");
            abort(500, "User already exists");
        }

        Log::info($team);

        $team->users()->attach(
            $user,
            ['role' => 'editor']
        );

        TeamMemberAdded::dispatch($team, $user);
    }
}
