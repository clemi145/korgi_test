<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
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

    function group(Request $request, $id)
    {
        $user = Auth::user();
        if ($team = Team::find($id + 1)) {
            $chats = Chat::where("fk_team_id", $id + 1)->get();

            if ($team == null) {
                echo "Error finding group";
            } else {

                return Inertia::render(
                    "Group/Group",
                    [
                        "user" => $user,
                        "group" => $team,
                        "group_url" => route("group.show", ["id" => $id]),
                        "chats" => $chats,
                        "user_is_admin" => $user->hasTeamRole($team, "admin")
                    ]
                );
            }
        } else {
            echo "Error finding group";
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

    function store(Request $request)
    {

        Log::info("Storing Group");

        $user = Auth::user();
        $team = Team::create([
            "name" => $request->input("name"),
            "personal_team" => false,
            "user_id" => $user->id,
        ]);

        $team->users()->attach(
            $user->id,
            ["role" => "admin"]
        );

        $general_chat = Chat::create([
            "fk_team_id" => $team->id,
            "type" => false,
            "url" => route("chat.show", [
                "id" => $team->id,
                "type" => "allgemein"
            ])
        ]);

        $important_chat = Chat::create([
            "fk_team_id" => $team->id,
            "type" => true,
            "url" => route("chat.show", [
                "id" => $team->id,
                "type" => "wichtig"
            ])
        ]);

        $general_chat->team()->associate($team);
        $important_chat->team()->associate($team);
    }

    function urlFormat($name)
    {
        $name = strtolower($name);
        return str_replace(" ", "-", $name);
    }

    function formatGroupsEloquentCollection(User $user, Collection $collection)
    {
        $groups = [];
        $chats= [];

        foreach ($collection as $team) {
            $chatsObject = Chat::where("fk_team_id", $team->id)->get();
            $uuids = [];

            foreach ($chatsObject as $chat) {
                array_push($chats, $chat);
                array_push($uuids, $chat->uuid);
            }

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

        $uuids = Chat::where("fk_team_id", $team->id)->get(["uuid"]);

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
            $chatsObject = Chat::where("fk_team_id", $team->id)->get();

            foreach ($chatsObject as $chat) {
                array_push($chats, $chat);
            }
        }
        return $chats;
    }
}
