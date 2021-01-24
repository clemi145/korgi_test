<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use SoareCostin\FileVault\Facades\FileVault;
use Illuminate\Support\Str;
use Inertia\Inertia;

class FileController extends Controller
{
    function show(Request $request, $url)
    {
        $team = Team::where("url", route("group.show", ["url" => $url]))->first();
        $dirName = 'files/' . $team->name . "_" . $team->id;
        $files = Storage::disk("ftp")->files($dirName);
        return Inertia::render("Group/Files", [
            "group" => $team,
            "files" => $files
        ]);
    }

    function store(Request $request)
    {
        $group = Team::find($request->groupId);
        $dirName = 'files/' . $group->name . "_" . $group->id;
        if (!Storage::exists($dirName)) {
            Storage::makeDirectory($dirName); //creates directory
        }
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $filename = Storage::disk("ftp")->put($dirName, $request->file('file'));

            if ($filename) {
                FileVault::disk("ftp")->encrypt($filename);
            }
        }

        return Redirect::route('home')->with('message', 'Upload complete');
    }

    function download(Request $request)
    {
        $group = Team::find($request->groupId);
        $filename = $request->filename;
        $groupName = $group->name;
        $groupId = $group->id;
        if (!Storage::disk("ftp")->exists('files/' . $groupName . "_" . $groupId . '/' . $filename)) {
            abort(404, "File not found!");
        }

        return response()->streamDownload(function () use ($filename, $groupName, $groupId) {
            FileVault::disk("ftp")->streamDecrypt('files/' . $groupName . "_" . $groupId . '/' . $filename);
        }, Str::replaceLast('.enc', '', $filename));
    }
}
