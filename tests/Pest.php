<?php

use Laravel\Pennant\Feature;
use LearnKit\Lms\Models\Team;
use LearnKit\LmsConnect\ConnectPlugin;

function createTeamAndActivatePlugin(): Team
{
    $team = Team::factory()->create();

    Feature::for($team)->activate(ConnectPlugin::class);

    return $team;
}
