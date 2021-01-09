<?php

namespace App\Models;

use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Team as JetstreamTeam;
use App\Models\Chat;
use App\Models\User;
// use Illuminate\Database\Eloquent\Concerns\HasRelationships;

class Team extends JetstreamTeam
{

    // use HasRelationships;

    protected $table = "teams";

    protected $primaryKey = "id";

    /*
    function users() {
        return $this->belongsToMany(User::class);
    }
    */

    function chats() {
        return $this->hasMany(Chat::class);
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'personal_team' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'personal_team',
        'user_id'
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];
}
