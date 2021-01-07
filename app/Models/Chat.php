<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Model;
use App\Models\Team;
use App\Models\User;

class Chat extends Model
{

    // use HasRelationships;

    protected $table = 'chat';

    protected $primaryKey = "id";

    function team()
    {
        return $this->belongsTo(Team::class, 'id');
    }

    protected $fillable = [
        "type",
        "url",
        "fk_team_id"
    ];
}
