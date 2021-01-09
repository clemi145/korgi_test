<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Inertia\Inertia;

class ChatController extends Controller
{
    function show(Request $request, $name)
    {

        $user = Auth::user();

        $team = Team::where("name", $name)->first();

        if ($team == null) {
            echo "Error finding group";
        } else {

            $group = $this->formatGroupTeam($user, $team);
            // $chats = Chat::where("fk_team_id", $team->id)->get();
            // $type_bool = $type == "wichtig" ? true : false;

            return Inertia::render(
                "Group/Group",
                [
                    "group" => $group,
                    // "chat" => $this->formatGroupTeam($user, $team)["channels"][$type],
                    "chats" => $this->formatGroupTeam($user, $team)["channels"],
                    // "type" => $type_bool,
                    "user_is_admin" => $group["hasAdminPermissions"]
                ]
            );
        }
    }

    function urlFormat($name)
    {
        $name = strtolower($name);
        return str_replace(" ", "-", $name);
    }

    function formatGroupEloquentCollection(User $user, Collection $collection)
    {
        $groups = [];

        foreach ($collection as $team) {
            $chatsObject = Chat::where("fk_team_id", $team->id)->get();
            $uuids = [];

            foreach ($chatsObject as $chat) {
                array_push($chats, $chat);
                array_push($uuids, $chat->uuid);
            }

            array_push($groups, [
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
            ]);
        }
        return $groups;
    }

    function formatGroupTeam(User $user, Team $team)
    {

        $uuids = Chat::where("fk_team_id", $team->id)->get(["uuid"]);

        return  [
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
                    "uuid" => $uuids[0]->uuid,
                ],
                "wichtig" => [
                    "name" => "Wichtig",
                    "url" => "wichtig",
                    "uuid" => $uuids[1]->uuid,
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
