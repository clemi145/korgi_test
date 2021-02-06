<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Inertia\Inertia;

class GroupController extends Controller
{

    function index(Request $request)
    {
        $user = Auth::user();

        $teams = $user->allTeams()->where("personal_team", 0);

        $groups = $this->formatGroupsEloquentCollection($user, $teams);
        $chats = $this->getChatsFromEloquentCollection($teams);

        return Inertia::render("App", [
            "user" => $user,
            "groups" => $groups,
            "chats" => $chats
        ]);
    }


    function store(Request $request)
    {

        Log::info("Storing Group");

        $user = Auth::user();
        $team = Team::create([
            "name" => $request->input("name"),
            "personal_team" => false,
            "user_id" => $user->id,
            "url" => route("group.show", [
                "url" => $this->urlFormat($request->input("name"))
            ])
        ]);

        $team->users()->attach(
            $user->id,
            ["role" => "admin"]
        );

        $general_chat = Chat::create([
            "team_id" => $team->id,
            "type" => false,
            "url" => route("group.show", [
                "url" => $this->urlFormat($team->name)
            ])
        ]);

        $important_chat = Chat::create([
            "team_id" => $team->id,
            "type" => true,
            "url" => route("group.show", [
                "url" => $this->urlFormat($team->name)
            ])
        ]);

        $general_chat->team()->associate($team);
        $important_chat->team()->associate($team);
    }

    function show(Request $request, $url)
    {
        $user = User::find(Auth::user()->id);

        $team = Team::where("url", route("group.show", ["url" => $url]))->first();

        // Log::info($team);

        if ($team == null) {
            echo "Error finding group";
        } else {
            $group = $this->formatGroupTeam($user, $team);
            // Log::info($group);
            return Inertia::render(
                "Group/Group",
                [
                    "group" => $group[$team->name],
                    "chats" => $group[$team->name]["channels"],
                    "user_is_admin" => $group[$team->name]["hasAdminPermissions"]
                ]
            );
        }
    }

    function join(Request $request, $uuid)
    {
        $user = Auth::user();
        $group = Team::where("uuid", $uuid)->first();
        return Inertia::render("Group/JoinGroup", [
            "user" => $user,
            "group" => $group,
        ]);
    }

    function leave(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $team = Team::where("uuid", $request->uuid)->first();
        if ($user->ownsTeam($team)) {
            if ($team->users->contains("role", "admin")) {
                DB::table("team_user")->where([
                    ["team_id", "=", $team->id],
                    ["user_id", "=", $user->id]
                ])->delete();
            } else {
                abort(500, "Can't leave when you're the only admin! To leave make someone else an Administrator");
            }
        } else {
            DB::table("team_user")->where([
                ["team_id", "=", $team->id],
                ["user_id", "=", $user->id]
            ])->delete();
        }
    }

    function delete(Request $request)
    {
        $team = Team::where("uuid", $request->uuid)->first();
        DB::table("team_user")->where("team_id", $team->id)->delete();
        foreach ($team->chats as $chat) {
            $chat->delete();
        }
        $team->delete();
    }

    function users(Request $request, $url)
    {
        $user = User::find(Auth::user()->id);
        $team = $user->allTeams()->where("url", route("group.show", ["url" => $url]))->first();

        return Inertia::render("Group/Users", [
            "group" => $team,
            "users" => $team->allUsers(),
            "isAdmin" => $user->hasTeamRole($team, "admin")
        ]);
    }

    function urlFormat($name)
    {
        $name = strtolower($name);
        return str_replace(" ", "-", $name);
    }

    function formatGroupsEloquentCollection(User $user, $collection)
    {
        $groups = [];
        $chats = [];

        foreach ($collection as $team) {
            $chatsObject = Chat::where("team_id", $team->id)->get();
            $uuids = [];

            foreach ($chatsObject as $chat) {
                array_push($chats, $chat);
                array_push($uuids, $chat->uuid);
                // Log::info($chat->uuid);
            }

            // Log::info($uuids);

            array_push($groups, [
                $this->urlFormat($team->name) => [
                    "id" => $team->id,
                    "uuid" => $team->uuid,
                    "name" => $team->name,
                    "url" => $this->urlFormat($team->name),
                    "hasAdminPermissions" => $user->hasTeamRole($team, "admin"),
                    "events" => [],
                    "channels" => [
                        "allgemein" => [
                            "name" => "Allgemein",
                            "url" => "allgemein",
                            "uuid" => $uuids[0],
                        ],
                        "wichtig" => [
                            "name" => "Wichtig",
                            "url" => "wichtig",
                            "uuid" => $uuids[1],
                        ]
                    ]
                ]
            ]);
        }
        return $groups;
    }

    function formatGroupTeam(User $user, Team $team)
    {
        $uuids = Chat::where("team_id", $team->id)->get(["uuid"]);

        return [
            $team->name => [
                "id" => $team->id,
                "uuid" => $team->uuid,
                "name" => $team->name,
                "url" => $this->urlFormat($team->name),
                "hasAdminPermissions" => $user->hasTeamRole($team, "admin"),
                "events" => [],
                "channels" => [
                    "allgemein" => [
                        "name" => "Allgemein",
                        "url" => "allgemein",
                        "uuid" => $uuids[0],
                    ],
                    "wichtig" => [
                        "name" => "Wichtig",
                        "url" => "wichtig",
                        "uuid" => $uuids[1],
                    ]
                ]
            ]
        ];
    }

    function getChatsFromEloquentCollection(Collection $collection)
    {
        $chats = [];
        foreach ($collection as $team) {
            $chatsObject = Chat::where("team_id", $team->id)->get();

            foreach ($chatsObject as $chat) {
                array_push($chats, $chat);
            }
        }
        return $chats;
    }
}