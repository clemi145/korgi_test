<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Team;

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
        "team_id",
        "uuid"
    ];
}
