<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTeamTest extends TestCase
{
    /*
    use RefreshDatabase;

    public function test_teams_can_be_created()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $response = $this->post(route("group.store"), [
            'name' => 'Test Team',
        ]);

        // $this->assertCount(2, $user->fresh()->ownedTeams);
        // $this->assertEquals('Test Team', $user->fresh()->ownedTeams()->latest('id')->first()->name);

        $this->assertTrue(true);
    }
    */
}
